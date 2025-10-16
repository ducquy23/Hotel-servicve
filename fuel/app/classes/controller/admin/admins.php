<?php

use Auth\Auth;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Str;
use Fuel\Core\View;

class Controller_Admin_Admins extends Controller_Admin_Base
{
    protected $service;

    public function before()
    {
        parent::before();
        $this->service = new Service_Admin();
    }

    public function action_index()
    {
        $keyword = Input::get('q', '');
        $role_filter = Input::get('role', '');
        $status_filter = Input::get('status', '');
        $page = (int) Input::get('page', 1);
        $per_page = 10;

        $filters = array();
        if ($keyword) { $filters['keyword'] = $keyword; }
        if ($role_filter) { $filters['group'] = $role_filter; }
        if ($status_filter) { $filters['status'] = $status_filter; }

        $result = $this->service->get_list($filters, $page, $per_page);

        $pagination = $result['pagination'];
        $pagination['start_page'] = max(1, $page - 2);
        $pagination['end_page'] = min($pagination['total_pages'], $page + 2);
        // Compat: view expects 'total' key
        if (!isset($pagination['total']) && isset($pagination['total_records'])) {
            $pagination['total'] = $pagination['total_records'];
        }

        $this->template->page_styles = array(
            'assets/vendors/css/forms/select/select2.min.css',
            'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            'assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
            'assets/css/base/plugins/forms/form-validation.css',
        );
        $this->template->page_scripts = array(
            'assets/vendors/js/tables/datatable/jquery.dataTables.min.js',
            'assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
            'assets/vendors/js/tables/datatable/dataTables.responsive.min.js',
            'assets/vendors/js/tables/datatable/responsive.bootstrap5.js',
            'assets/vendors/js/tables/datatable/datatables.buttons.min.js',
            'assets/vendors/js/tables/datatable/jszip.min.js',
            'assets/vendors/js/tables/datatable/pdfmake.min.js',
            'assets/vendors/js/tables/datatable/vfs_fonts.js',
            'assets/vendors/js/tables/datatable/buttons.html5.min.js',
            'assets/vendors/js/tables/datatable/buttons.print.min.js',
            'assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js',
        );

        $this->template->title = 'Quản lý Admin';
        $this->template->content = View::forge('admin/admins/index', array(
            'rows' => $result['rows'],
            'keyword' => $keyword,
            'role_filter' => $role_filter,
            'status_filter' => $status_filter,
            'pagination' => $pagination,
        ));
    }

	public function action_create()
	{
		$data = array('errors' => array());
		if (Input::method() === 'POST') {
			$username = trim((string) Input::post('username'));
			$email = trim((string) Input::post('email'));
			$full_name = trim((string) Input::post('full_name'));
			$group = (int) Input::post('group', 100);
			$status = trim((string) Input::post('status', 'active'));
			$password = (string) Input::post('password');
			$confirm = (string) Input::post('password_confirm');
			$avatar = null;
			if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
				$file = $_FILES['avatar'];
				$allowed_types = array('jpg', 'jpeg', 'png', 'gif');
				$max_size = 2 * 1024 * 1024; // 2MB

				if ($file['size'] > $max_size) {
					$data['errors'][] = 'File quá lớn. Tối đa 2MB.';
				} else {
					$file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					if (!in_array($file_ext, $allowed_types)) {
						$data['errors'][] = 'Chỉ chấp nhận file: JPG, PNG, GIF';
					} else {
						$new_filename = uniqid() . '_' . time() . '.' . $file_ext;
						$upload_path = DOCROOT . 'uploads/avatars/' . $new_filename;
						if (move_uploaded_file($file['tmp_name'], $upload_path)) {
							$avatar = $new_filename;
						} else {
							$data['errors'][] = 'Không thể upload file';
						}
					}
				}
			}

			if ($username === '' || $email === '' || $password === '' || $confirm === '') {
				$data['errors'][] = 'Vui lòng nhập đầy đủ thông tin';
			} elseif ($password !== $confirm) {
				$data['errors'][] = 'Mật khẩu xác nhận không khớp';
			}

            if (empty($data['errors'])) {
                try {
                    $this->service->create(array(
                        'username' => $username,
                        'password' => $password,
                        'email' => $email,
                        'full_name' => $full_name,
                        'group' => $group,
                        'status' => $status,
                        'avatar' => $avatar,
                    ));
                    Session::set_flash('success', 'Tạo admin thành công');
                    Response::redirect('admin/admins');
                    return;
                } catch (Exception $e) {
                    $data['errors'][] = 'Không thể tạo admin: '.$e->getMessage();
                }
            }
		}
		$this->template->title = 'Tạo admin';
		$this->template->content = View::forge('admin/admins/create', $data);
	}

	public function action_edit($id = null)
	{
		if (!$id) { Response::redirect('admin/admins'); }
		$row = DB::query('SELECT id, username, email, full_name, `group`, status, avatar FROM admins WHERE id = :id')->parameters(array(':id' => $id))->execute()->current();
		if (!$row) { Session::set_flash('error', 'Không tìm thấy admin'); Response::redirect('admin/admins'); }

		$data = array('row' => $row, 'errors' => array());
		if (Input::method() === 'POST') {
			$email = trim((string) Input::post('email'));
			$full_name = trim((string) Input::post('full_name'));
			$group = (int) Input::post('group', 100);
			$status = trim((string) Input::post('status', 'active'));
			$avatar = null;

			// Xử lý upload avatar
			if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
				$file = $_FILES['avatar'];
				$allowed_types = array('jpg', 'jpeg', 'png', 'gif');
				$max_size = 2 * 1024 * 1024; // 2MB
				
				// Kiểm tra kích thước file
				if ($file['size'] > $max_size) {
					$data['errors'][] = 'File quá lớn. Tối đa 2MB.';
				} else {
					// Lấy extension
					$file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					
					// Kiểm tra loại file
					if (!in_array($file_ext, $allowed_types)) {
						$data['errors'][] = 'Chỉ chấp nhận file: JPG, PNG, GIF';
					} else {
						// Tạo tên file mới
						$new_filename = uniqid() . '_' . time() . '.' . $file_ext;
						$upload_path = DOCROOT . 'uploads/avatars/' . $new_filename;
						
						// Upload file
						if (move_uploaded_file($file['tmp_name'], $upload_path)) {
							$avatar = $new_filename;
						} else {
							$data['errors'][] = 'Không thể upload file';
						}
					}
				}
			}

			try {
                $this->service->update($id, array(
                    'email' => $email,
                    'full_name' => $full_name,
                    'group' => $group,
                    'status' => $status,
                    'avatar' => $avatar ?: null,
                ));
				Session::set_flash('success', 'Cập nhật admin thành công');
				Response::redirect('admin/admins');
				return;
			} catch (Exception $e) {
				$data['errors'][] = 'Lỗi: '.$e->getMessage();
			}
		}

		$this->template->title = 'Sửa admin';
		$this->template->content = View::forge('admin/admins/edit', $data);
	}

	public function action_toggle($id = null)
	{
		if (!$id) { Response::redirect('admin/admins'); }
		DB::query('UPDATE admins SET status = IF(status = "active","inactive","active") WHERE id = :id')
			->parameters(array(':id' => $id))->execute();
		Session::set_flash('success', 'Đổi trạng thái thành công');
		Response::redirect('admin/admins');
	}

	public function action_reset_password($id = null)
	{
		if (!$id) { Response::redirect('admin/admins'); }
		$newpass = Str::random('alnum', 10);
		try {
			$hash = Auth::hash_password($newpass);
			DB::query('UPDATE admins SET password = :p WHERE id = :id')
				->parameters(array(':p' => $hash, ':id' => $id))
				->execute();
			Session::set_flash('success', 'Mật khẩu mới: '.$newpass);
		} catch (Exception $e) {
			Session::set_flash('error', 'Không thể reset: '.$e->getMessage());
		}
		Response::redirect('admin/admins');
	}
}
