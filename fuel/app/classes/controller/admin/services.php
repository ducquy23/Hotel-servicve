<?php

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

class Controller_Admin_Services extends Controller_Admin_Base
{
	/**
	 * Service instance
	 * @var Service_Service
	 */
	protected $service;

	/**
	 * Constructor
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Service();
	}

    /**
     * Danh sách services
     */
    public function action_index()
    {
		try {
			$status = Input::get('status', '');
            $keyword = Input::get('q', '');
			$page = (int) Input::get('page', 1);
			$per_page = 20;

			$filters = [];
			if ($status) {
				$filters['status'] = $status;
			}
			if ($keyword) {
				$filters['name'] = $keyword;
			}
			$result = $this->service->get_list($filters, $page, $per_page);

			$data = array(
				'rows' => $result['rows'],
				'status' => $status,
				'keyword' => $keyword,
				'pagination' => $result['pagination'],
			);

			$this->template->page_styles = array(
				'assets/vendors/css/forms/select/select2.min.css',
				'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
				'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
				'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
				'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
				'assets/css/base/plugins/forms/form-validation.css',
			);

			$this->template->title = 'Quản lý Dịch vụ';
			$this->template->content = View::forge('admin/services/index', $data);

		} catch (\Exception $e) {
			Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
			Response::redirect('admin/dashboard');
		}
	}

    /**
     * @return void
     */
    public function action_create()
	{
		$data = array('errors' => array());

		if (Input::method() === 'POST') {
			try {
				$form_data = array(
					'name' => Input::post('name'),
					'description' => Input::post('description'),
					'icon' => Input::post('icon'),
					'price' => Input::post('price') ?: null,
					'status' => Input::post('status'),
				);
				$this->service->create($form_data);

				Session::set_flash('success', 'Tạo dịch vụ thành công');
				Response::redirect('admin/services');

			} catch (\Exception $e) {
				$data['errors'][] = $e->getMessage();
			}
		}

		$this->template->page_styles = array(
			'assets/vendors/css/forms/select/select2.min.css',
			'assets/css/base/plugins/forms/form-validation.css',
		);

		$this->template->title = 'Tạo Dịch vụ';
		$this->template->content = View::forge('admin/services/create', $data);
	}

    /**
     * @param $id
     * @return void
     */
    public function action_edit($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy dịch vụ');
			Response::redirect('admin/services');
		}

		try {
			// Lấy thông tin service từ service layer
			$service = $this->service->get_by_id($id);

			if (!$service) {
				Session::set_flash('error', 'Không tìm thấy dịch vụ');
				Response::redirect('admin/services');
			}

			$data = array('service' => $service, 'errors' => array());

			if (Input::method() === 'POST') {
				try {
					$form_data = array(
						'name' => Input::post('name'),
						'description' => Input::post('description'),
						'icon' => Input::post('icon'),
						'price' => Input::post('price') ?: null,
						'status' => Input::post('status'),
					);
					$this->service->update($id, $form_data);

					Session::set_flash('success', 'Cập nhật dịch vụ thành công');
					Response::redirect('admin/services');

				} catch (\Exception $e) {
					$data['errors'][] = $e->getMessage();
				}
			}

			$this->template->page_styles = array(
				'assets/vendors/css/forms/select/select2.min.css',
				'assets/css/base/plugins/forms/form-validation.css',
			);

			$this->template->title = 'Chỉnh sửa Dịch vụ';
			$this->template->content = View::forge('admin/services/edit', $data);

		} catch (\Exception $e) {
			Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
			Response::redirect('admin/services');
		}
	}

    /**
     * @param $id
     * @return void
     */
    public function action_toggle($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy dịch vụ');
			Response::redirect('admin/services');
		}

		try {
			$this->service->toggle_status($id);
			Session::set_flash('success', 'Cập nhật trạng thái thành công');
		} catch (\Exception $e) {
			Session::set_flash('error', $e->getMessage());
		}

		Response::redirect('admin/services');
	}

    /**
     * @param $id
     * @return void
     */
    public function action_delete($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy dịch vụ');
			Response::redirect('admin/services');
		}

		try {
			$this->service->delete($id);
			Session::set_flash('success', 'Xóa dịch vụ thành công');
		} catch (\Exception $e) {
			Session::set_flash('error', $e->getMessage());
		}

		Response::redirect('admin/services');
	}

    /**
     * @return void
     */
    public function action_bulk_update_status()
	{
		if (Input::method() !== 'POST') {
			Response::forge(json_encode(array('success' => false, 'message' => 'Method not allowed')), 405);
			return;
		}

		try {
			$ids = Input::post('ids', array());
			$status = Input::post('status');

			if (empty($ids) || !$status) {
				throw new \Exception('Dữ liệu không hợp lệ');
			}

			$this->service->bulk_update_status($ids, $status);

			Response::forge(json_encode(array(
				'success' => true,
				'message' => 'Cập nhật trạng thái thành công'
			)), 200);

		} catch (\Exception $e) {
			Response::forge(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

    /**
     * @return void
     */
    public function action_bulk_delete()
	{
		if (Input::method() !== 'POST') {
			Response::forge(json_encode(array('success' => false, 'message' => 'Method not allowed')), 405);
			return;
		}

		try {
			$ids = Input::post('ids', array());

			if (empty($ids)) {
				throw new \Exception('Dữ liệu không hợp lệ');
			}

			$this->service->bulk_delete($ids);

			Response::forge(json_encode(array(
				'success' => true,
				'message' => 'Xóa thành công'
			)), 200);

		} catch (\Exception $e) {
			Response::forge(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

    /**
     * @return void
     */
    public function action_statistics()
	{
		try {
			$stats = $this->service->get_statistics();

			Response::forge(json_encode(array(
				'success' => true,
				'data' => $stats
			)), 200);

		} catch (\Exception $e) {
			Response::forge(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}
}
