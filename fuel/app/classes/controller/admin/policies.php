<?php

class Controller_Admin_Policies extends Controller_Admin_Base
{
	/**
	 * Danh sách chính sách khách sạn
	 */
	public function action_index()
	{
		$data = array();
		
		// Get filter parameters
		$hotel_id = \Input::get('hotel_id');
		$policy_type = \Input::get('policy_type');
		$status = \Input::get('status');
		
		// Build query
		$where_conditions = array();
		$params = array();
		
		if ($hotel_id) {
			$where_conditions[] = 'hp.hotel_id = :hotel_id';
			$params[':hotel_id'] = $hotel_id;
		}
		
		if ($policy_type) {
			$where_conditions[] = 'hp.policy_type = :policy_type';
			$params[':policy_type'] = $policy_type;
		}
		
		if ($status) {
			$where_conditions[] = 'hp.status = :status';
			$params[':status'] = $status;
		}
		
		$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
		
		$sql = "SELECT hp.*, h.name as hotel_name
			FROM hotel_policies hp
			LEFT JOIN hotels h ON h.id = hp.hotel_id
			{$where_clause}
			ORDER BY hp.hotel_id, hp.display_order, hp.policy_type";
		
		$data['policies'] = \DB::query($sql)->parameters($params)->execute()->as_array();
		
		// Get hotels for filter
		$data['hotels'] = \DB::query('SELECT id, name FROM hotels WHERE status = :status ORDER BY name')
			->parameters(array(':status' => 'active'))
			->execute()->as_array();
		
		$this->template->title = 'Chính sách khách sạn';
		$this->template->content = \View::forge('admin/hotel_policies/index', $data);
	}
	
	/**
	 * Tạo chính sách mới
	 */
	public function action_create()
	{
		$ajax = \Input::is_ajax();
		if (\Input::method() === 'POST') {
			$hotel_id = \Input::post('hotel_id');
			$policy_type = \Input::post('policy_type');
			$title = \Input::post('title');
			$description = \Input::post('description');
			$is_mandatory = \Input::post('is_mandatory', 0) ? 1 : 0;
			$display_order = \Input::post('display_order', 0);
			$status = \Input::post('status', 'active');
			
			try {
				$sql = 'INSERT INTO hotel_policies (hotel_id, policy_type, title, description, is_mandatory, display_order, status, created_at, updated_at) 
					VALUES (:hotel_id, :policy_type, :title, :description, :is_mandatory, :display_order, :status, NOW(), NOW())';
				
				$ins = \DB::query($sql)->parameters(array(
					':hotel_id' => $hotel_id,
					':policy_type' => $policy_type,
					':title' => $title,
					':description' => $description,
					':is_mandatory' => $is_mandatory,
					':display_order' => $display_order,
					':status' => $status
				))->execute();

				if ($ajax) {
					return \Response::forge(json_encode(array('success' => true)), 200, array('Content-Type' => 'application/json'));
				}
				
				\Session::set_flash('success', 'Tạo chính sách thành công!');
				\Response::redirect(\Uri::create('admin/hotel-policies'));
				
			} catch (\Exception $e) {
				if ($ajax) {
					return \Response::forge(json_encode(array('success' => false, 'message' => $e->getMessage())), 500, array('Content-Type' => 'application/json'));
				}
				\Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
				\Response::redirect(\Uri::create('admin/hotel-policies'));
			}
		}
		
		\Response::redirect(\Uri::create('admin/hotel-policies'));
	}
	
	/**
	 * Cập nhật chính sách
	 */
	public function action_update($id = null)
	{
		$ajax = \Input::is_ajax();
		if (!$id || \Input::method() !== 'POST') {
			\Response::redirect(\Uri::create('admin/hotel-policies'));
		}
		
		$hotel_id = \Input::post('hotel_id');
		$policy_type = \Input::post('policy_type');
		$title = \Input::post('title');
		$description = \Input::post('description');
		$is_mandatory = \Input::post('is_mandatory', 0) ? 1 : 0;
		$display_order = \Input::post('display_order', 0);
		$status = \Input::post('status', 'active');
		
		try {
			$sql = 'UPDATE hotel_policies 
				SET hotel_id = :hotel_id,
					policy_type = :policy_type,
					title = :title,
					description = :description,
					is_mandatory = :is_mandatory,
					display_order = :display_order,
					status = :status,
					updated_at = NOW()
				WHERE id = :id';
			
			\DB::query($sql)->parameters(array(
				':id' => $id,
				':hotel_id' => $hotel_id,
				':policy_type' => $policy_type,
				':title' => $title,
				':description' => $description,
				':is_mandatory' => $is_mandatory,
				':display_order' => $display_order,
				':status' => $status
			))->execute();
			if ($ajax) {
				return \Response::forge(json_encode(array('success' => true)), 200, array('Content-Type' => 'application/json'));
			}
			\Session::set_flash('success', 'Cập nhật chính sách thành công!');
			
		} catch (\Exception $e) {
			if ($ajax) {
				return \Response::forge(json_encode(array('success' => false, 'message' => $e->getMessage())), 500, array('Content-Type' => 'application/json'));
			}
			\Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
		}
		
		\Response::redirect(\Uri::create('admin/hotel-policies'));
	}
	
	/**
	 * Lấy thông tin chính sách (AJAX)
	 */
	public function action_get($id = null)
	{
		$ajax = \Input::is_ajax();
		if (!$id) {
			return \Response::forge(json_encode(array('success' => false, 'message' => 'Thiếu id')), 400, array('Content-Type' => 'application/json'));
		}
		
		try {
			$sql = 'SELECT hp.*, h.name as hotel_name
				FROM hotel_policies hp
				LEFT JOIN hotels h ON h.id = hp.hotel_id
				WHERE hp.id = :id';
			
			$result = \DB::query($sql)->parameters(array(':id' => $id))->execute()->as_array();
			if (!empty($result)) {
				return \Response::forge(json_encode(array('success' => true, 'data' => $result[0])), 200, array('Content-Type' => 'application/json'));
			}
			return \Response::forge(json_encode(array('success' => false, 'message' => 'Không tìm thấy')), 404, array('Content-Type' => 'application/json'));
			
		} catch (\Exception $e) {
			return \Response::forge(json_encode(array('success' => false, 'message' => $e->getMessage())), 500, array('Content-Type' => 'application/json'));
		}
	}
	
	/**
	 * Xóa chính sách
	 */
	public function action_delete($id = null)
	{
		$ajax = \Input::is_ajax();
		if (!$id) {
			return \Response::forge(json_encode(array('success' => false, 'message' => 'Thiếu id')), 400, array('Content-Type' => 'application/json'));
		}
		
		try {
			\DB::query('DELETE FROM hotel_policies WHERE id = :id')
				->parameters(array(':id' => $id))
				->execute();
			if ($ajax) {
				return \Response::forge(json_encode(array('success' => true)), 200, array('Content-Type' => 'application/json'));
			}
			\Session::set_flash('success', 'Xóa chính sách thành công!');
			
		} catch (\Exception $e) {
			if ($ajax) {
				return \Response::forge(json_encode(array('success' => false, 'message' => $e->getMessage())), 500, array('Content-Type' => 'application/json'));
			}
			\Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
		}
		
		\Response::redirect(\Uri::create('admin/hotel-policies'));
	}
}
