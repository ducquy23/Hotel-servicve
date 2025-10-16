<?php

class Controller_Admin_Contacts extends Controller_Admin_Base
{
	/**
	 * Danh sách liên hệ
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
			$where_conditions[] = 'status = :status';
			$params[':status'] = $status;
		}
		
		if ($keyword) {
			$where_conditions[] = '(name LIKE :keyword OR email LIKE :keyword OR subject LIKE :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
		}
		
		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}
		
		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM contacts " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];
		
		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;
		
		// Lấy dữ liệu
		$query = "SELECT * FROM contacts " . $where_clause . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
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
            'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
            'assets/css/base/plugins/forms/form-validation.css',
        );
		
		$this->template->title = 'Quản lý Liên hệ';
		$this->template->content = \View::forge('admin/contacts/index', $data);
	}
	
	/**
	 * Xem chi tiết liên hệ
	 */
	public function action_view($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy liên hệ');
			\Response::redirect('admin/contacts');
		}
		
		$contact = \DB::query('SELECT * FROM contacts WHERE id = :id')
			->parameters(array(':id' => $id))
			->execute();
			
		if (empty($contact)) {
			\Session::set_flash('error', 'Không tìm thấy liên hệ');
			\Response::redirect('admin/contacts');
		}
		
		$data['contact'] = $contact[0];
		
		// Cập nhật trạng thái thành đã đọc nếu chưa đọc
		if ($data['contact']['status'] === 'new') {
			\DB::query('UPDATE contacts SET status = "read", updated_at = NOW() WHERE id = :id')
				->parameters(array(':id' => $id))
				->execute();
			$data['contact']['status'] = 'read';
		}
		
		$this->template->title = 'Chi tiết Liên hệ';
		$this->template->content = \View::forge('admin/contacts/view', $data);
	}
	
	/**
	 * Cập nhật trạng thái liên hệ
	 */
	public function action_update_status($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy liên hệ');
			\Response::redirect('admin/contacts');
		}
		
		$status = \Input::post('status');
		$valid_statuses = array('new', 'read', 'replied', 'closed');
		
		if (!in_array($status, $valid_statuses)) {
			\Session::set_flash('error', 'Trạng thái không hợp lệ');
			\Response::redirect('admin/contacts');
		}
		
		try {
			\DB::query('UPDATE contacts SET status = :status, updated_at = NOW() WHERE id = :id')
				->parameters(array(
					':status' => $status,
					':id' => $id
				))
				->execute();
				
			\Session::set_flash('success', 'Cập nhật trạng thái thành công');
		} catch (\Exception $e) {
			\Session::set_flash('error', 'Không thể cập nhật trạng thái: ' . $e->getMessage());
		}
		
		\Response::redirect('admin/contacts/view/' . $id);
	}
	
	/**
	 * Xóa liên hệ
	 */
	public function action_delete($id = null)
	{
		if (!$id) {
			\Session::set_flash('error', 'Không tìm thấy liên hệ');
			\Response::redirect('admin/contacts');
		}
		
		try {
			\DB::query('DELETE FROM contacts WHERE id = :id')
				->parameters(array(':id' => $id))
				->execute();
				
			\Session::set_flash('success', 'Xóa liên hệ thành công');
		} catch (\Exception $e) {
			\Session::set_flash('error', 'Không thể xóa liên hệ: ' . $e->getMessage());
		}
		
		\Response::redirect('admin/contacts');
	}
}
