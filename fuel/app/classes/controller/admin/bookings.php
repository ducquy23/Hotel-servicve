<?php

class Controller_Admin_Bookings extends Controller_Admin_Base
{
	/**
	 * Danh sách booking
	 */
	public function action_index()
	{
		$data = array();
		
		// Lấy tham số filter
		$status = \Input::get('status', '');
		$keyword = \Input::get('q', '');
		$page = (int) \Input::get('page', 1);
		$per_page = 20;
		
		// Xây dựng query
		$where_conditions = array();
		$params = array();
		
		if ($status) {
			$where_conditions[] = 'b.status = :status';
			$params[':status'] = $status;
		}
		
		if ($keyword) {
			$where_conditions[] = '(b.booking_reference LIKE :keyword OR u.full_name LIKE :keyword OR h.name LIKE :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
		}
		
		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}
		
		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM bookings b 
						LEFT JOIN users u ON b.user_id = u.id 
						LEFT JOIN hotels h ON b.hotel_id = h.id 
						LEFT JOIN rooms r ON b.room_id = r.id " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];
		
		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;
		
		// Lấy dữ liệu
		$query = "SELECT b.*, u.full_name as user_name, u.email as user_email, h.name as hotel_name, r.name as room_name 
				  FROM bookings b 
				  LEFT JOIN users u ON b.user_id = u.id 
				  LEFT JOIN hotels h ON b.hotel_id = h.id 
				  LEFT JOIN rooms r ON b.room_id = r.id 
				  " . $where_clause . " 
				  ORDER BY b.created_at DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = max(0, $offset);
		
		$rows = \DB::query($query)->parameters($params)->execute();
		
		$data['rows'] = $rows;
		$data['status'] = $status;
		$data['keyword'] = $keyword;
		$data['pagination'] = array(
			'current_page' => $page,
			'total_pages' => $total_pages,
			'total_records' => $total_records,
			'per_page' => $per_page,
			'start' => $offset + 1,
			'end' => min($offset + $per_page, $total_records),
		);
		
		$this->template->page_styles = array(
			'assets/vendors/css/forms/select/select2.min.css',
			'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
			'assets/css/base/plugins/forms/form-validation.css',
		);
		
		$this->template->title = 'Quản lý Booking';
		$this->template->content = \View::forge('admin/bookings/index', $data);
	}
	
	/**
	 * Xem chi tiết booking
	 */
	public function action_view($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy booking');
			\Response::redirect('admin/bookings');
		}
		
		$booking = \DB::query('SELECT b.*, u.full_name as user_name, u.email as user_email, u.phone as user_phone, h.name as hotel_name, r.name as room_name 
							   FROM bookings b 
							   LEFT JOIN users u ON b.user_id = u.id 
							   LEFT JOIN hotels h ON b.hotel_id = h.id 
							   LEFT JOIN rooms r ON b.room_id = r.id 
							   WHERE b.id = :id')
			->parameters(array(':id' => $id))
			->execute();
			
		if (empty($booking)) {
			\Session::set_flash('error', 'Không tìm thấy booking');
			\Response::redirect('admin/bookings');
		}
		
		$data['booking'] = $booking[0];
		
		// Get booking rooms details
		$booking_rooms = \DB::query('SELECT br.*, r.name as room_name, r.room_type
									FROM booking_rooms br
									LEFT JOIN rooms r ON r.id = br.room_id
									WHERE br.booking_id = :booking_id')
			->parameters(array(':booking_id' => $id))
			->execute()->as_array();
		$data['booking_rooms'] = $booking_rooms;
		
		// Get booking amenities
		$booking_amenities = \DB::query('SELECT ba.*, a.name as amenity_name
										FROM booking_amenities ba
										LEFT JOIN amenities a ON a.id = ba.amenity_id
										WHERE ba.booking_id = :booking_id')
			->parameters(array(':booking_id' => $id))
			->execute()->as_array();
		$data['booking_amenities'] = $booking_amenities;
		
		$this->template->title = 'Chi tiết Booking';
		$this->template->content = \View::forge('admin/bookings/view', $data);
	}
	
	/**
	 * Cập nhật trạng thái booking
	 */
	public function action_update_status($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy booking');
			\Response::redirect('admin/bookings');
		}
		
		$status = \Input::post('status');
		$valid_statuses = array('pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show');
		
		if (!in_array($status, $valid_statuses)) {
			\Session::set_flash('error', 'Trạng thái không hợp lệ');
			\Response::redirect('admin/bookings');
		}
		
		try {
			\DB::query('UPDATE bookings SET status = :status, updated_at = NOW() WHERE id = :id')
				->parameters(array(
					':status' => $status,
					':id' => $id
				))
				->execute();
				
			\Session::set_flash('success', 'Cập nhật trạng thái thành công');
		} catch (\Exception $e) {
			\Session::set_flash('error', 'Không thể cập nhật trạng thái: ' . $e->getMessage());
		}
		
		\Response::redirect('admin/bookings/view/' . $id);
	}
	
	/**
	 * Hủy booking
	 */
	public function action_cancel($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy booking');
			\Response::redirect('admin/bookings');
		}
		
		$reason = \Input::post('cancellation_reason', '');
		
		try {
			\DB::query('UPDATE bookings SET status = "cancelled", cancellation_reason = :reason, updated_at = NOW() WHERE id = :id')
				->parameters(array(
					':reason' => $reason,
					':id' => $id
				))
				->execute();
				
			\Session::set_flash('success', 'Hủy booking thành công');
		} catch (\Exception $e) {
			\Session::set_flash('error', 'Không thể hủy booking: ' . $e->getMessage());
		}
		
		\Response::redirect('admin/bookings/view/' . $id);
	}
	
	/**
	 * Xóa booking
	 */
	public function action_delete($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy booking');
			\Response::redirect('admin/bookings');
		}
		
		try {
			\DB::query('DELETE FROM bookings WHERE id = :id')
				->parameters(array(':id' => $id))
				->execute();
				
			\Session::set_flash('success', 'Xóa booking thành công');
		} catch (\Exception $e) {
			\Session::set_flash('error', 'Không thể xóa booking: ' . $e->getMessage());
		}
		
		\Response::redirect('admin/bookings');
	}
}
