<?php

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

class Controller_Admin_Amenities extends Controller_Admin_Base
{
	/**
	 * @var Service_Amenity
	 */
	protected $service;

	/**
	 * Before action
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Amenity();
	}

    /**
     * @return void
     */
    public function action_index()
	{
		$keyword = Input::get('q', '');
		$status_filter = Input::get('status', '');
		$category_filter = Input::get('category', '');
		$page = (int) Input::get('page', 1);
		$per_page = 10;

		$filters = array();
		if ($status_filter) {
			$filters['status'] = $status_filter;
		}
		if ($category_filter) {
			$filters['category'] = $category_filter;
		}
		if ($keyword) {
			$filters['name'] = $keyword;
		}

		$result = $this->service->get_list($filters, $page, $per_page);

		$data = array(
			'rows' => $result['rows'],
			'keyword' => $keyword,
			'status_filter' => $status_filter,
			'category_filter' => $category_filter,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $result['pagination']['total_pages'],
				'total' => $result['pagination']['total_records'],
				'start' => $result['pagination']['start'],
				'end' => $result['pagination']['end'],
				'start_page' => max(1, $page - 2),
				'end_page' => min($result['pagination']['total_pages'], $page + 2)
			)
		);

		$this->template->title = 'Quản lý Tiện ích';
		$this->template->content = View::forge('admin/amenities/index', $data);
	}

    /**
     * @return void
     */
    public function action_create()
	{
		$data = array('errors' => array());
		
		if (Input::method() === 'POST') {
			$amenity_data = array(
				'name' => trim((string) Input::post('name')),
				'description' => trim((string) Input::post('description')),
				'icon' => trim((string) Input::post('icon')),
				'category' => trim((string) Input::post('category')),
				'status' => trim((string) Input::post('status')),
				'price' => Input::post('price') !== null && Input::post('price') !== '' ? (float) Input::post('price') : null,
				'service_type' => trim((string) Input::post('service_type', 'free')),
				'is_24h' => (int) (Input::post('is_24h') ? 1 : 0),
				'operating_hours' => trim((string) Input::post('operating_hours')) ?: null,
			);

			$errors = $this->service->validate($amenity_data);
			if (!empty($errors)) {
				$data['errors'] = $errors;
			} else {
				try {
					$this->service->create($amenity_data);
					
					Session::set_flash('success', 'Tạo tiện ích thành công');
					Response::redirect('admin/amenities');
					return;
				} catch (Exception $e) {
					$data['errors'][] = 'Không thể tạo tiện ích: ' . $e->getMessage();
				}
			}
		}

		$this->template->title = 'Tạo Tiện ích';
		$this->template->content = View::forge('admin/amenities/create', $data);
	}

    /**
     * @param $id
     * @return void
     */
    public function action_edit($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy tiện ích');
			Response::redirect('admin/amenities');
		}
		
		try {
			$amenity = $this->service->get_by_id($id);
			if (!$amenity) {
				Session::set_flash('error', 'Không tìm thấy tiện ích');
				Response::redirect('admin/amenities');
			}
		} catch (Exception $e) {
			Session::set_flash('error', 'Lỗi: '.$e->getMessage());
			Response::redirect('admin/amenities');
		}
		
		$data = array('amenity' => $amenity, 'errors' => array());
		
		if (Input::method() === 'POST') {
		$amenity_data = array(
				'name' => trim((string) Input::post('name')),
				'description' => trim((string) Input::post('description')),
				'icon' => trim((string) Input::post('icon')),
				'category' => trim((string) Input::post('category')),
				'status' => trim((string) Input::post('status')),
				'price' => Input::post('price') !== null && Input::post('price') !== '' ? (float) Input::post('price') : null,
				'service_type' => trim((string) Input::post('service_type', 'free')),
				'is_24h' => (int) (Input::post('is_24h') ? 1 : 0),
				'operating_hours' => trim((string) Input::post('operating_hours')) ?: null,
			);

			$errors = $this->service->validate($amenity_data, true);
			if (!empty($errors)) {
				$data['errors'] = $errors;
			} else {
				try {
					$this->service->update($id, $amenity_data);
					
					Session::set_flash('success', 'Cập nhật tiện ích thành công');
					Response::redirect('admin/amenities');
					return;
				} catch (Exception $e) {
					$data['errors'][] = 'Không thể cập nhật tiện ích: ' . $e->getMessage();
				}
			}
		}

		$this->template->title = 'Sửa Tiện ích';
		$this->template->content = View::forge('admin/amenities/edit', $data);
	}

    /**
     * @param $id
     * @return void
     */
    public function action_toggle($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy tiện ích');
			Response::redirect('admin/amenities');
		}
		
		try {
			$this->service->toggle_status($id);
			Session::set_flash('success', 'Đổi trạng thái tiện ích thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể đổi trạng thái: ' . $e->getMessage());
		}
		
		Response::redirect('admin/amenities');
	}

    /**
     * @param $id
     * @return void
     */
    public function action_delete($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy tiện ích');
			Response::redirect('admin/amenities');
		}
		
		try {
			$this->service->delete($id);
			Session::set_flash('success', 'Xóa tiện ích thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể xóa: ' . $e->getMessage());
		}
		
		Response::redirect('admin/amenities');
	}
}