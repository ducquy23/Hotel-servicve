<?php

use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

class Controller_Admin_Rooms extends Controller_Admin_Base
{
	/**
	 * @var Service_Room
	 */
	protected $service;

	/**
	 * Before action
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Room();
	}
    /**
     * @return void
     */
    public function action_index()
    {
        $keyword = Input::get('q', '');
        $status_filter = Input::get('status', '');
        $hotel_filter = (int) Input::get('hotel_id', 0);
        $page = (int) Input::get('page', 1);
        $per_page = 10;

        // Build filters for service
        $filters = array();
        if ($keyword) {
            $filters['name'] = $keyword;
        }
        if ($status_filter) {
            $filters['status'] = $status_filter;
        }
        if ($hotel_filter > 0) {
            $filters['hotel_id'] = $hotel_filter;
        }

        // Get data from service
        $result = $this->service->get_list_with_hotel($filters, $page, $per_page);

        $hotels = DB::query('SELECT id, name FROM hotels WHERE status = "active" ORDER BY name ASC')->execute();

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
        $this->template->title = 'Quản lý Phòng';
        $this->template->content = View::forge('admin/rooms/index', array(
            'rows' => $result['rows'],
            'keyword' => $keyword,
            'status_filter' => $status_filter,
            'hotel_filter' => $hotel_filter,
            'hotels' => $hotels,
            'pagination' => $pagination,
        ));
    }

    /**
     * @return void
     */
    public function action_create()
    {
        $data = array('errors' => array());
        $hotels = DB::query('SELECT id, name FROM hotels WHERE status = "active" ORDER BY name ASC')->execute();
        $data['hotels'] = $hotels;

        if (Input::method() === 'POST') {
            $room_data = array(
                'hotel_id' => (int) Input::post('hotel_id', 0),
                'name' => trim((string) Input::post('name')),
                'price' => (float) Input::post('price', 0),
                'capacity' => (int) Input::post('capacity', 1),
                'size' => trim((string) Input::post('size')),
                'bed_type' => trim((string) Input::post('bed_type')),
                'room_type' => trim((string) Input::post('room_type')),
                'view_type' => trim((string) Input::post('view_type')),
                'status' => trim((string) Input::post('status', 'active')),
                'description' => trim((string) Input::post('description')),
            );

            // Validate using service
            $errors = $this->service->validate($room_data);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    $room_id = $this->service->create($room_data);
                    $this->upload_room_images($room_id);

                    Session::set_flash('success', 'Tạo phòng thành công');
                    Response::redirect('admin/rooms');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Không thể tạo phòng: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Tạo Phòng';
        $this->template->content = View::forge('admin/rooms/create', $data);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_edit($id = null)
    {
        if (!$id) { Response::redirect('admin/rooms'); }
        
        try {
            $row = $this->service->get_by_id($id);
            if (!$row) { 
                Session::set_flash('error', 'Không tìm thấy phòng'); 
                Response::redirect('admin/rooms'); 
            }
        } catch (Exception $e) {
            Session::set_flash('error', 'Lỗi: '.$e->getMessage());
            Response::redirect('admin/rooms');
        }

        $data = array('row' => $row, 'errors' => array());
        $hotels = DB::query('SELECT id, name FROM hotels WHERE status = "active" ORDER BY name ASC')->execute();
        $data['hotels'] = $hotels;
        $images = DB::query('SELECT id, image_url AS image_path, is_primary FROM room_images WHERE room_id = :rid ORDER BY id ASC')
            ->parameters(array(':rid' => $id))->execute();
        $data['images'] = $images;

        if (Input::method() === 'POST') {
            $room_data = array(
                'hotel_id' => (int) Input::post('hotel_id', 0),
                'name' => trim((string) Input::post('name')),
                'price' => (float) Input::post('price', 0),
                'capacity' => (int) Input::post('capacity', 1),
                'size' => trim((string) Input::post('size')),
                'bed_type' => trim((string) Input::post('bed_type')),
                'room_type' => trim((string) Input::post('room_type')),
                'view_type' => trim((string) Input::post('view_type')),
                'status' => trim((string) Input::post('status', 'active')),
                'description' => trim((string) Input::post('description')),
            );

            // Validate using service
            $errors = $this->service->validate($room_data, true);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    $this->service->update($id, $room_data);
                    $this->upload_room_images($id);

                    Session::set_flash('success', 'Cập nhật phòng thành công');
                    Response::redirect('admin/rooms');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Không thể cập nhật phòng: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Sửa Phòng';
        $this->template->content = View::forge('admin/rooms/edit', $data);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_toggle($id = null)
    {
        if (!$id) { Response::redirect('admin/rooms'); }
        try {
            $this->service->toggle_status($id);
            Session::set_flash('success', 'Đổi trạng thái thành công');
        } catch (Exception $e) {
            Session::set_flash('error', 'Không thể đổi trạng thái: '.$e->getMessage());
        }
        Response::redirect('admin/rooms');
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_delete($id = null)
    {
        if (!$id) { Response::redirect('admin/rooms'); }
        try {
            DB::query('DELETE FROM room_images WHERE room_id = :rid')->parameters(array(':rid' => $id))->execute();
            $this->service->delete($id);
            
            Session::set_flash('success', 'Xóa phòng thành công');
        } catch (Exception $e) {
            Session::set_flash('error', 'Không thể xóa: '.$e->getMessage());
        }
        Response::redirect('admin/rooms');
    }

    private function upload_room_images($room_id)
    {
        if (empty($_FILES['images'])) { return; }
        if (!is_array($_FILES['images']['name'])) {
            $_FILES['images'] = array(
                'name' => array($_FILES['images']['name']),
                'type' => array($_FILES['images']['type'] ?? ''),
                'tmp_name' => array($_FILES['images']['tmp_name'] ?? ''),
                'error' => array($_FILES['images']['error'] ?? 4),
                'size' => array($_FILES['images']['size'] ?? 0),
            );
        }
        $upload_dir = DOCROOT . 'uploads/rooms/';
        if (!is_dir($upload_dir)) { @mkdir($upload_dir, 0755, true); }
        $names = $_FILES['images']['name'];
        $tmps = $_FILES['images']['tmp_name'];
        $errs = $_FILES['images']['error'];
        $cnt = is_array($names) ? count($names) : 0;
        $has_primary = (int) DB::query('SELECT COUNT(*) AS c FROM room_images WHERE room_id = :rid AND is_primary = 1')->parameters(array(':rid' => $room_id))->execute()->current()['c'] > 0;
        $added = 0;
        for ($i = 0; $i < $cnt; $i++) {
            if (!isset($errs[$i]) || $errs[$i] !== 0 || empty($tmps[$i])) { continue; }
            if (!is_uploaded_file($tmps[$i])) { continue; }
            $ext = strtolower(pathinfo($names[$i], PATHINFO_EXTENSION));
            if (!in_array($ext, array('jpg','jpeg','png','gif','webp'))) { continue; }
            $new = uniqid('room_') . '_' . time() . '.' . $ext;
            if (move_uploaded_file($tmps[$i], $upload_dir . $new)) {
                DB::query('INSERT INTO room_images (room_id, image_url, is_primary, created_at, updated_at) VALUES (:rid, :path, :pri, :created, :updated)')
                    ->parameters(array(
                        ':rid' => $room_id,
                        ':path' => 'uploads/rooms/' . $new,
                        ':pri' => ($has_primary ? 0 : ($added === 0 ? 1 : 0)),
                        ':sort' => $added + 1,
                        ':created' => time(),
                        ':updated' => time(),
                    ))->execute();
                $added++;
            }
        }
    }

	/**
	 * Delete room image via AJAX
	 */
	public function action_delete_image($image_id)
	{
		// Clear any output buffer to prevent HTML/errors from interfering
		if (ob_get_level()) {
			ob_clean();
		}
		
		$data = array(
			'success' => false,
			'message' => 'Có lỗi xảy ra'
		);
		
		try {
			// Validate image_id
			if (empty($image_id) || !is_numeric($image_id)) {
				$data['message'] = 'ID ảnh không hợp lệ';
			} else {
				// Get image info - use try-catch for DB query
				$image_result = null;
				try {
					$image_result = DB::query('SELECT * FROM room_images WHERE id = :id')
						->parameters(array(':id' => $image_id))
						->execute();
				} catch (Exception $db_error) {
					$data['message'] = 'Lỗi database: ' . $db_error->getMessage();
					throw $db_error;
				}
				
				// Check if query returned valid result
				if ($image_result === false || $image_result === null) {
					$data['message'] = 'Lỗi truy vấn database';
				} elseif (empty($image_result) || (is_array($image_result) && count($image_result) == 0)) {
					$data['message'] = 'Ảnh không tồn tại';
				} else {
					// Get first image record
					$image = null;
					if (is_array($image_result) && isset($image_result[0])) {
						$image = $image_result[0];
					} elseif (is_object($image_result) && method_exists($image_result, 'as_array')) {
						$image_array = $image_result->as_array();
						$image = isset($image_array[0]) ? $image_array[0] : null;
					}
					
					if ($image === null) {
						$data['message'] = 'Không thể đọc thông tin ảnh';
					} else {
						// Delete file from filesystem
						if (isset($image['image_url']) && !empty($image['image_url'])) {
							$file_path = DOCROOT . $image['image_url'];
							if (file_exists($file_path)) {
								unlink($file_path);
							}
						}
						
						// Delete from database
						DB::query('DELETE FROM room_images WHERE id = :id')
							->parameters(array(':id' => $image_id))
							->execute();
						
						// If deleted image was primary, set another as primary
						if (isset($image['is_primary']) && $image['is_primary'] == 1 && isset($image['room_id'])) {
							$remaining_images = DB::query('SELECT id FROM room_images WHERE room_id = :room_id ORDER BY created_at ASC LIMIT 1')
								->parameters(array(':room_id' => $image['room_id']))
								->execute();
							
							if (!empty($remaining_images) && is_array($remaining_images) && isset($remaining_images[0]['id'])) {
								DB::query('UPDATE room_images SET is_primary = 1 WHERE id = :id')
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


