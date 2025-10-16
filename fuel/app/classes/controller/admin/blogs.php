<?php

use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;
use Fuel\Core\Validation;

class Controller_Admin_Blogs extends Controller_Admin_Base
{
	/**
	 * @var Service_Blog
	 */
	protected $service;

	/**
	 * Before action
	 */
	public function before()
	{
		parent::before();
		$this->service = new Service_Blog();
	}

    /**
     * @return void
     */
    public function action_index()
	{
		// Lấy tham số filter
		$status = Input::get('status', '');
		$category = Input::get('category', '');
		$keyword = Input::get('q', '');
		$page = (int) Input::get('page', 1);
		$per_page = 20;

		// Build filters for service
		$filters = array();
		if ($status) {
			$filters['status'] = $status;
		}
		if ($category) {
			$filters['category'] = $category;
		}
		if ($keyword) {
			$filters['title'] = $keyword;
		}

		// Get data from service
		$result = $this->service->get_list($filters, $page, $per_page);

		$data = array(
			'rows' => $result['rows'],
			'status' => $status,
			'category' => $category,
			'keyword' => $keyword,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $result['pagination']['total_pages'],
				'total_records' => $result['pagination']['total_records'],
				'per_page' => $per_page,
				'start' => $result['pagination']['start'],
				'end' => $result['pagination']['end'],
			)
		);

		$this->template->page_styles = array(
			'assets/vendors/css/forms/select/select2.min.css',
			'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
			'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
			'assets/vendors/css/editors/quill/katex.min.css',
			'assets/vendors/css/editors/quill/monokai-sublime.min.css',
			'assets/vendors/css/editors/quill/katex.min.css',
			'assets/vendors/css/editors/quill/quill.snow.css',
			'assets/vendors/css/editors/quill/quill.bubble.css',
			'assets/css/base/plugins/forms/form-validation.css',
		);

		$this->template->title = 'Quản lý Blog';
		$this->template->content = View::forge('admin/blogs/index', $data);
	}

    /**
     * @return void
     */
    public function action_create()
	{
		$data = array('errors' => array());
		
		if (Input::method() === 'POST') {
			$blog_data = array(
				'title' => trim((string) Input::post('title')),
				'content' => trim((string) Input::post('content')),
				'excerpt' => trim((string) Input::post('excerpt')),
				// featured_image sẽ được xử lý trong Service_Blog qua $_FILES
				'category' => trim((string) Input::post('category')),
				'status' => trim((string) Input::post('status')),
			);

			// Validate using service
			$errors = $this->service->validate($blog_data);
			if (!empty($errors)) {
				$data['errors'] = $errors;
			} else {
				try {
					// Create blog using service
					$this->service->create($blog_data);
					
					Session::set_flash('success', 'Tạo blog thành công');
					Response::redirect('admin/blogs');
					return;
				} catch (Exception $e) {
					$data['errors'][] = 'Không thể tạo blog: ' . $e->getMessage();
				}
			}
		}
		
		$data['categories'] = Model_Blog::get_category_options();
		
		$this->template->page_styles = array(
			'assets/vendors/css/forms/select/select2.min.css',
			'assets/vendors/css/editors/quill/katex.min.css',
			'assets/vendors/css/editors/quill/monokai-sublime.min.css',
			'assets/vendors/css/editors/quill/quill.snow.css',
			'assets/vendors/css/editors/quill/quill.bubble.css',
			'assets/css/base/plugins/forms/form-validation.css',
		);

        $this->template->page_scripts = array(
            'assets/vendors/js/editors/quill/katex.min.js',
            'assets/vendors/js/editors/quill/highlight.min.js',
            'assets/vendors/js/editors/quill/quill.min.js',
            'assets/js/scripts/forms/form-quill-editor.js'
        );
		
		$this->template->title = 'Tạo Blog';
		$this->template->content = View::forge('admin/blogs/create', $data);
	}

    /**
     * @param $id
     * @return void
     */
    public function action_edit($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy blog');
			Response::redirect('admin/blogs');
		}
		
		try {
			$blog = $this->service->get_by_id($id);
			if (!$blog) {
				Session::set_flash('error', 'Không tìm thấy blog');
				Response::redirect('admin/blogs');
			}
		} catch (Exception $e) {
			Session::set_flash('error', 'Lỗi: '.$e->getMessage());
			Response::redirect('admin/blogs');
		}
		
		$data = array('blog' => $blog, 'errors' => array());
		
		if (Input::method() === 'POST') {
			$blog_data = array(
				'title' => trim((string) Input::post('title')),
				'content' => trim((string) Input::post('content')),
				'excerpt' => trim((string) Input::post('excerpt')),
				// Không set featured_image nếu không upload mới; Service_Blog sẽ giữ ảnh cũ
				'category' => trim((string) Input::post('category')),
				'status' => trim((string) Input::post('status')),
			);

			// Validate using service
			$errors = $this->service->validate($blog_data, true);
			if (!empty($errors)) {
				$data['errors'] = $errors;
			} else {
				try {
					$this->service->update($id, $blog_data);
					
					Session::set_flash('success', 'Cập nhật blog thành công');
					Response::redirect('admin/blogs');
					return;
				} catch (Exception $e) {
					$data['errors'][] = 'Không thể cập nhật blog: ' . $e->getMessage();
				}
			}
		}
		
		$data['categories'] = Model_Blog::get_category_options();

        $this->template->page_styles = array(
            'assets/vendors/css/forms/select/select2.min.css',
            'assets/vendors/css/editors/quill/katex.min.css',
            'assets/vendors/css/editors/quill/monokai-sublime.min.css',
            'assets/vendors/css/editors/quill/quill.snow.css',
            'assets/vendors/css/editors/quill/quill.bubble.css',
            'assets/css/base/plugins/forms/form-validation.css',
        );

        $this->template->page_scripts = array(
            'assets/vendors/js/editors/quill/katex.min.js',
            'assets/vendors/js/editors/quill/highlight.min.js',
            'assets/vendors/js/editors/quill/quill.min.js',
            'assets/js/scripts/forms/form-quill-editor.js'
        );
		
		$this->template->title = 'Chỉnh sửa Blog';
		$this->template->content = View::forge('admin/blogs/edit', $data);
	}

    /**
     * @param $id
     * @return void
     */
    public function action_toggle($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy blog');
			Response::redirect('admin/blogs');
		}
		
		try {
			$this->service->toggle_status($id);
			Session::set_flash('success', 'Cập nhật trạng thái thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể cập nhật trạng thái: ' . $e->getMessage());
		}
		
		Response::redirect('admin/blogs');
	}

    /**
     * @param $id
     * @return void
     */
    public function action_delete($id = null)
	{
		if (!$id) {
			Session::set_flash('error', 'Không tìm thấy blog');
			Response::redirect('admin/blogs');
		}
		
		try {
			$this->service->delete($id);
			Session::set_flash('success', 'Xóa blog thành công');
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể xóa blog: ' . $e->getMessage());
		}
		
		Response::redirect('admin/blogs');
	}

	/**
	 * Delete blog featured image via AJAX
	 */
	public function action_delete_image($blog_id)
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
			// Validate blog_id
			if (empty($blog_id) || !is_numeric($blog_id)) {
				$data['message'] = 'ID blog không hợp lệ';
			} else {
				// Get blog info
				$blog_result = DB::query('SELECT featured_image FROM blogs WHERE id = :id')
					->parameters(array(':id' => $blog_id))
					->execute();
				
				// Check if query returned valid result
				if ($blog_result === false || $blog_result === null) {
					$data['message'] = 'Lỗi truy vấn database';
				} elseif (empty($blog_result) || (is_array($blog_result) && count($blog_result) == 0)) {
					$data['message'] = 'Blog không tồn tại';
				} else {
					// Get first blog record
					$blog = null;
					if (is_array($blog_result) && isset($blog_result[0])) {
						$blog = $blog_result[0];
					} elseif (is_object($blog_result) && method_exists($blog_result, 'as_array')) {
						$blog_array = $blog_result->as_array();
						$blog = isset($blog_array[0]) ? $blog_array[0] : null;
					}
					
					if ($blog === null) {
						$data['message'] = 'Không thể đọc thông tin blog';
					} else {
						// Delete file from filesystem
						if (isset($blog['featured_image']) && !empty($blog['featured_image'])) {
							$file_path = DOCROOT . $blog['featured_image'];
							if (file_exists($file_path)) {
								unlink($file_path);
							}
						}
						
						// Update database to remove featured_image
						DB::query('UPDATE blogs SET featured_image = NULL WHERE id = :id')
							->parameters(array(':id' => $blog_id))
							->execute();
						
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
