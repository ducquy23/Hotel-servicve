<?php

use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

class Controller_Admin_Categories extends Controller_Admin_Base
{
	/**
	 * @var Service_Category
	 */
	protected $service;

	/**
	 * Before action
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Category();
	}
    /**
     * @return void
     */
    public function action_index()
    {
        $keyword = Input::get('q', '');
        $status_filter = Input::get('status', '');
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

        // Get data from service
        $result = $this->service->get_list_with_hotels_count($filters, $page, $per_page);

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
        
        $this->template->title = 'Quản lý Loại Khách sạn';
        $this->template->content = View::forge('admin/categories/index', array(
            'rows' => $result['rows'], 
            'keyword' => $keyword,
            'status_filter' => $status_filter,
            'pagination' => $pagination
        ));
    }

    /**
     * @return void
     */
    public function action_create()
    {
        $data = array('errors' => array());
        if (Input::method() === 'POST') {
            $category_data = array(
                'name' => trim((string) Input::post('name')),
                'description' => trim((string) Input::post('description')),
                'icon' => trim((string) Input::post('icon')),
                'status' => trim((string) Input::post('status', 'active')),
            );

            // Validate using service
            $errors = $this->service->validate($category_data);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    $this->service->create($category_data);
                    
                    Session::set_flash('success', 'Tạo loại khách sạn thành công');
                    Response::redirect('admin/categories');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Không thể tạo loại khách sạn: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Tạo loại khách sạn';
        $this->template->content = View::forge('admin/categories/create', $data);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_edit($id = null)
    {
        if (!$id) { Response::redirect('admin/categories'); }
        
        try {
            $row = $this->service->get_by_id($id);
            if (!$row) { 
                Session::set_flash('error', 'Không tìm thấy loại khách sạn'); 
                Response::redirect('admin/categories'); 
            }
        } catch (Exception $e) {
            Session::set_flash('error', 'Lỗi: '.$e->getMessage());
            Response::redirect('admin/categories');
        }

        $data = array('row' => $row, 'errors' => array());
        if (Input::method() === 'POST') {
            $category_data = array(
                'name' => trim((string) Input::post('name')),
                'description' => trim((string) Input::post('description')),
                'icon' => trim((string) Input::post('icon')),
                'status' => trim((string) Input::post('status', 'active')),
            );

            $errors = $this->service->validate($category_data, true);
            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                try {
                    $this->service->update($id, $category_data);
                    
                    Session::set_flash('success', 'Cập nhật loại khách sạn thành công');
                    Response::redirect('admin/categories');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Lỗi: '.$e->getMessage();
                }
            }
        }

        $this->template->title = 'Sửa loại khách sạn';
        $this->template->content = View::forge('admin/categories/edit', $data);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_toggle($id = null)
    {
        if (!$id) { Response::redirect('admin/categories'); }
        try {
            $this->service->toggle_status($id);
            Session::set_flash('success', 'Đổi trạng thái thành công');
        } catch (Exception $e) {
            Session::set_flash('error', 'Không thể đổi trạng thái: '.$e->getMessage());
        }
        Response::redirect('admin/categories');
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function action_delete($id = null)
    {
        if (!$id) { Response::redirect('admin/categories'); }
        try {
            $this->service->delete($id);
            Session::set_flash('success', 'Xóa loại khách sạn thành công');
        } catch (Exception $e) {
            Session::set_flash('error', $e->getMessage());
        }
        Response::redirect('admin/categories');
    }
}
