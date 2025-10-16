<?php

use Fuel\Core\Config;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;

class Controller_Admin_Hotels extends Controller_Admin_Base
{
	/**
	 * @var Service_Hotel
	 */
	protected $service;

	/**
	 * Before action
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Hotel();
	}


    /**
     * @param $province_id
     * @return Response
     */
    public function action_wards($province_id = null)
    {
        Config::set('security.csrf_autoload', false);
        $json_headers = array('Content-Type' => 'application/json; charset=utf-8');

        if (!$province_id) {
            return Response::forge(json_encode(array('status' => 'error', 'message' => 'Thiếu province_id')), 400, $json_headers);
        }

        try {
            $rows = DB::query('SELECT id, name FROM wards WHERE province_id = :pid ORDER BY name ASC')
                ->parameters(array(':pid' => (int) $province_id))
                ->execute();
            return Response::forge(json_encode(array('status' => 'ok', 'data' => $rows->as_array())), 200, $json_headers);
        } catch (\Exception $e) {
            return Response::forge(json_encode(array('status' => 'error', 'message' => $e->getMessage())), 500, $json_headers);
        }
    }

    /**
     * @return void
     */
    public function action_index()
    {
        $keyword = Input::get('q', '');
        $status_filter = Input::get('status', '');
        $category_filter = Input::get('category', '');
        $page = (int) Input::get('page', '1');
        $per_page = 10;
        
        // Build filters for service
        $filters = array();
        if ($keyword) {
            $filters['name'] = $keyword;
        }
        if ($status_filter) {
            $filters['status'] = $status_filter;
        }
        if ($category_filter) {
            $filters['category_id'] = $category_filter;
        }

        $result = $this->service->get_list_with_province($filters, $page, $per_page);

        $categories = DB::query('SELECT id, name FROM categories WHERE status = "active" ORDER BY name ASC')->execute();
		
		// Pagination data for view
		$pagination = array(
			'current_page' => $page,
			'total_pages' => $result['pagination']['total_pages'],
			'total' => $result['pagination']['total_records'],
			'start' => $result['pagination']['start'],
			'end' => $result['pagination']['end'],
			'start_page' => max(1, $page - 2),
			'end_page' => min($result['pagination']['total_pages'], $page + 2)
		);
        
        $this->template->page_styles = array(
            'assets/vendors/css/forms/select/select2.min.css',
            'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
            'assets/css/base/plugins/forms/form-validation.css',
        );
        $this->template->title = 'Quản lý Khách sạn';
        $this->template->content = View::forge('admin/hotels/index', array(
            'rows' => $result['rows'], 
            'keyword' => $keyword,
            'status_filter' => $status_filter,
            'category_filter' => $category_filter,
            'categories' => $categories,
            'pagination' => $pagination
        ));
	}

    /**
     * @return void
     */
    public function action_create()
    {
        $data = array('errors' => array());
        $categories = DB::query('SELECT id, name FROM categories WHERE status = "active" ORDER BY name ASC')->execute();
        $provinces = DB::query('SELECT id, name FROM provinces ORDER BY name ASC')->execute();
        $wards = DB::query('SELECT id, name FROM wards ORDER BY name ASC')->execute();
        $amenities = DB::query('SELECT id, name FROM amenities WHERE status = "active" ORDER BY name ASC')->execute();
        $data['categories'] = $categories;
        $data['provinces'] = $provinces;
        $data['wards'] = $wards;
        $data['amenities'] = $amenities;
        
        if (Input::method() === 'POST') {
            $hotel_data = array(
                'name' => trim((string) Input::post('name')),
                'description' => trim((string) Input::post('description')),
                'address' => trim((string) Input::post('address')),
                'country' => 'Việt Nam',
                'phone' => trim((string) Input::post('phone')),
                'email' => trim((string) Input::post('email')),
                'rating' => (float) Input::post('rating', 0),
                'status' => trim((string) Input::post('status', 'active')),
                'category_id' => (int) Input::post('category_id', 0),
                'star_rating' => (int) Input::post('star_rating', 3),
                'website' => trim((string) Input::post('website')),
                'latitude' => trim((string) Input::post('latitude')) ?: null,
                'longitude' => trim((string) Input::post('longitude')) ?: null,
                'province_id' => (int) Input::post('province_id', 0),
                'ward_id' => (int) Input::post('ward_id', 0),
                // New fields
                'checkin_time' => trim((string) Input::post('checkin_time', '14:00')),
                'checkout_time' => trim((string) Input::post('checkout_time', '12:00')),
                'manager_name' => trim((string) Input::post('manager_name')),
                'manager_phone' => trim((string) Input::post('manager_phone')),
                'wifi_password' => trim((string) Input::post('wifi_password')),
                'facebook' => trim((string) Input::post('facebook')),
                'instagram' => trim((string) Input::post('instagram')),
                'is_featured' => (int) Input::post('is_featured', 0),
                'cancellation_policy' => trim((string) Input::post('cancellation_policy')),
            );

            // Get city from province
            if ($hotel_data['province_id'] > 0) {
                $prov = DB::query('SELECT name FROM provinces WHERE id = :id LIMIT 1')
                    ->parameters(array(':id' => $hotel_data['province_id']))
                    ->execute();
                if (count($prov)) {
                    $hotel_data['city'] = (string) $prov->current()['name'];
                }
            }

            // Validate using service
            $errors = $this->service->validate($hotel_data);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    $hotel_id = $this->service->create($hotel_data);

                    $amenity_ids = (array) Input::post('amenities', array());
                    if (!empty($amenity_ids)) {
                        foreach ($amenity_ids as $aid) {
                            $aid = (int) $aid;
                            if ($aid > 0) {
                                DB::query('INSERT INTO hotel_amenities (hotel_id, amenity_id, created_at, updated_at) VALUES (:hid, :aid, NOW(), NOW())')
                                    ->parameters(array(':hid' => $hotel_id, ':aid' => $aid))
                                    ->execute();
                            }
                        }
                    }
                    $this->upload_hotel_images($hotel_id);
                    
                    Session::set_flash('success', 'Tạo khách sạn thành công');
                    Response::redirect('admin/hotels');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Không thể tạo khách sạn: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Tạo khách sạn';
        $this->template->content = View::forge('admin/hotels/create', $data);
    }

    public function action_edit($id = null)
    {
        if (!$id) { Response::redirect('admin/hotels'); }
        
        try {
            $row = $this->service->get_by_id($id);
            if (!$row) { 
                Session::set_flash('error', 'Không tìm thấy khách sạn'); 
                Response::redirect('admin/hotels'); 
            }
        } catch (Exception $e) {
            Session::set_flash('error', 'Lỗi: '.$e->getMessage());
            Response::redirect('admin/hotels');
        }

        $data = array('row' => $row, 'errors' => array());
        
        // Get categories, provinces, wards, amenities for dropdowns
        $categories = DB::query('SELECT id, name FROM categories WHERE status = "active" ORDER BY name ASC')->execute();
        $provinces = DB::query('SELECT id, name FROM provinces ORDER BY name ASC')->execute();
        $wards = DB::query('SELECT id, name FROM wards ORDER BY name ASC')->execute();
        $amenities = DB::query('SELECT id, name FROM amenities WHERE status = "active" ORDER BY name ASC')->execute();
        $data['categories'] = $categories;
        $data['provinces'] = $provinces;
        $data['wards'] = $wards;
        $data['amenities'] = $amenities;

        // Selected amenities for this hotel
        $selected_rows = DB::query('SELECT amenity_id FROM hotel_amenities WHERE hotel_id = :hid')
            ->parameters(array(':hid' => $id))
            ->execute();
        $selected_amenities = array();
        foreach ($selected_rows as $r) { $selected_amenities[] = (int) $r['amenity_id']; }
        $data['selected_amenities'] = $selected_amenities;

        // Existing images for preview
        $images = DB::query('SELECT id, image_path, is_primary, sort_order FROM hotel_images WHERE hotel_id = :hid ORDER BY sort_order ASC, id ASC')
            ->parameters(array(':hid' => $id))
            ->execute();
        $data['images'] = $images;
        
        if (Input::method() === 'POST') {
            $hotel_data = array(
                'name' => trim((string) Input::post('name')),
                'description' => trim((string) Input::post('description')),
                'address' => trim((string) Input::post('address')),
                // Kinh doanh tại Việt Nam: cố định quốc gia
                'country' => 'Việt Nam',
                'phone' => trim((string) Input::post('phone')),
                'email' => trim((string) Input::post('email')),
                'rating' => (float) Input::post('rating', 0),
                'status' => trim((string) Input::post('status', 'active')),
                'category_id' => (int) Input::post('category_id', 0),
                'star_rating' => (int) Input::post('star_rating', 3),
                'website' => trim((string) Input::post('website')),
                'latitude' => trim((string) Input::post('latitude')) ?: null,
                'longitude' => trim((string) Input::post('longitude')) ?: null,
                'province_id' => (int) Input::post('province_id', 0),
                'ward_id' => (int) Input::post('ward_id', 0),
                // New fields
                'checkin_time' => trim((string) Input::post('checkin_time', '14:00')),
                'checkout_time' => trim((string) Input::post('checkout_time', '12:00')),
                'manager_name' => trim((string) Input::post('manager_name')),
                'manager_phone' => trim((string) Input::post('manager_phone')),
                'wifi_password' => trim((string) Input::post('wifi_password')),
                'facebook' => trim((string) Input::post('facebook')),
                'instagram' => trim((string) Input::post('instagram')),
                'is_featured' => (int) Input::post('is_featured', 0),
                'cancellation_policy' => trim((string) Input::post('cancellation_policy')),
            );

            // Get city from province
            if ($hotel_data['province_id'] > 0) {
                $prov = DB::query('SELECT name FROM provinces WHERE id = :id LIMIT 1')
                    ->parameters(array(':id' => $hotel_data['province_id']))
                    ->execute();
                if (count($prov)) {
                    $hotel_data['city'] = (string) $prov->current()['name'];
                }
            }

            // Validate using service
            $errors = $this->service->validate($hotel_data, true);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    // Update hotel using service
                    $this->service->update($id, $hotel_data);

                    // Update amenities
                    $amenity_ids = (array) Input::post('amenities', array());
                    DB::query('DELETE FROM hotel_amenities WHERE hotel_id = :hid')->parameters(array(':hid' => $id))->execute();
                    if (!empty($amenity_ids)) {
                        foreach ($amenity_ids as $aid) {
                            $aid = (int) $aid;
                            if ($aid > 0) {
                                DB::query('INSERT INTO hotel_amenities (hotel_id, amenity_id, created_at, updated_at) VALUES (:hid, :aid, NOW(), NOW())')
                                    ->parameters(array(':hid' => $id, ':aid' => $aid))
                                    ->execute();
                            }
                        }
                    }

                    // Handle additional image uploads
                    $this->upload_hotel_images($id);
                    
                    Session::set_flash('success', 'Cập nhật khách sạn thành công');
                    Response::redirect('admin/hotels');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Lỗi: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Sửa khách sạn';
        $this->template->content = View::forge('admin/hotels/edit', $data);
    }

	public function action_toggle($id = null)
	{
		if (!$id) { Response::redirect('admin/hotels'); }
		try {
			$this->service->toggle_status($id);
			Session::set_flash('success', 'Đổi trạng thái thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể đổi trạng thái: '.$e->getMessage());
		}
		Response::redirect('admin/hotels');
	}

	public function action_delete($id = null)
	{
		if (!$id) { Response::redirect('admin/hotels'); }
		try {
			$this->service->delete($id);
			Session::set_flash('success', 'Xóa khách sạn thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể xóa: '.$e->getMessage());
		}
		Response::redirect('admin/hotels');
	}

	/**
	 * Upload hotel images helper method
	 */
	private function upload_hotel_images($hotel_id)
	{
		if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
			$upload_dir = DOCROOT . 'uploads/hotels/';
			if (!is_dir($upload_dir)) { @mkdir($upload_dir, 0755, true); }
			$names = $_FILES['images']['name'];
			$tmps = $_FILES['images']['tmp_name'];
			$errs = $_FILES['images']['error'];
			$count = count($names);
			$inserted = 0;
			for ($i = 0; $i < $count; $i++) {
				if ($errs[$i] !== 0 || empty($tmps[$i])) { continue; }
				$ext = strtolower(pathinfo($names[$i], PATHINFO_EXTENSION));
				if (!in_array($ext, array('jpg','jpeg','png','gif','webp'))) { continue; }
				$new = uniqid('hotel_') . '_' . time() . '.' . $ext;
				if (move_uploaded_file($tmps[$i], $upload_dir . $new)) {
					DB::query('INSERT INTO hotel_images (hotel_id, image_path, is_primary, sort_order, created_at, updated_at) VALUES (:hid, :path, :pri, :sort, NOW(), NOW())')
						->parameters(array(
							':hid' => $hotel_id,
							':path' => 'uploads/hotels/' . $new,
							':pri' => ($inserted === 0 ? 1 : 0),
							':sort' => $inserted + 1,
						))
						->execute();
					$inserted++;
				}
			}
		}
	}

	/**
	 * Delete hotel image via AJAX
	 */
	public function action_delete_image($image_id)
	{
		// Clear any output buffer to prevent HTML/errors from interfering
		if (ob_get_level()) {
			ob_clean();
		}
		
		try {
			// Get image info using different approach
			$query = DB::query('SELECT * FROM hotel_images WHERE id = :id');
			$query->parameters(array(':id' => $image_id));
			$image_result = $query->execute();
			
			// Convert to array if it's a DB result object
			if (is_object($image_result)) {
				$image_result = $image_result->as_array();
			}
			
			// Check if result is valid
			if ($image_result === false || $image_result === null) {
				$data = array(
					'success' => false,
					'message' => 'Lỗi truy vấn database'
				);
			} elseif (empty($image_result) || !is_array($image_result) || count($image_result) == 0) {
				$data = array(
					'success' => false,
					'message' => 'Ảnh không tồn tại'
				);
			} else {
				$image = $image_result[0];
				
				// Validate image data
				if (!is_array($image) || !isset($image['id'])) {
					$data = array(
						'success' => false,
						'message' => 'Dữ liệu ảnh không hợp lệ'
					);
				} else {
					// Delete file from filesystem
					if (isset($image['image_path']) && !empty($image['image_path'])) {
						$file_path = DOCROOT . $image['image_path'];
						if (file_exists($file_path)) {
							unlink($file_path);
						}
					}
					
					// Delete from database
					DB::query('DELETE FROM hotel_images WHERE id = :id')
						->parameters(array(':id' => $image_id))
						->execute();
					
					// If deleted image was primary, set another as primary
					if (isset($image['is_primary']) && $image['is_primary'] == 1 && isset($image['hotel_id'])) {
						$remaining_images = DB::query('SELECT id FROM hotel_images WHERE hotel_id = :hotel_id ORDER BY sort_order ASC LIMIT 1')
							->parameters(array(':hotel_id' => $image['hotel_id']))
							->execute();
						
						if (!empty($remaining_images) && is_array($remaining_images) && isset($remaining_images[0]['id'])) {
							DB::query('UPDATE hotel_images SET is_primary = 1 WHERE id = :id')
								->parameters(array(':id' => $remaining_images[0]['id']))
								->execute();
						}
					}
					
					$data = array(
						'success' => true,
						'message' => 'Xóa ảnh thành công'
					);
				}
			}
			
		} catch (Exception $e) {
			$data = array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			);
		}
		
		// Send JSON response
		$response = Response::forge(json_encode($data), 200);
		$response->set_header('Content-Type', 'application/json');
		$response->set_header('Cache-Control', 'no-cache');
		$response->send();
		exit; // Prevent any further output
	}
}


