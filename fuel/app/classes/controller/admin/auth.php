<?php

use Auth\Auth;
use Email\Email;
use Fuel\Core\Config;
use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Package;
use Fuel\Core\Request;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

class Controller_Admin_Auth extends Controller_Template
{

	public $template = 'layouts/fullLayoutMaster';

	public function before()
	{
		parent::before();
		if (Auth::check() && in_array(Request::active()->action, array('login'))) {
			Response::redirect('admin/dashboard/index');
		}
	}

	public function action_login()
	{
		$data = array();
		$this->template->title = 'Login admin';

		if (Input::method() === 'POST') {
			$username = trim((string) Input::post('username', ''));
			$password = (string) Input::post('password', '');

            if (Auth::login($username, $password)) {
                $admin = DB::query('SELECT id, username, full_name, avatar, status FROM admins WHERE username = :username OR email = :username')
                    ->parameters(array(':username' => $username))
					->execute();
				
				if (!empty($admin)) {
					$admin_data = $admin[0];
                    if (isset($admin_data['status']) && $admin_data['status'] === 'inactive') {
                        Auth::logout();
                        Session::set_flash('error', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email để xác nhận.');
                        Response::redirect('admin/login');
                        return;
                    }
					Session::set('admin_id', $admin_data['id']);
					Session::set('admin_username', $admin_data['username']);
					Session::set('admin_name', $admin_data['full_name'] ?: $admin_data['username']);
					Session::set('admin_avatar', $admin_data['avatar']);
				}
				
				Session::set_flash('success', 'Đăng nhập thành công');
				Response::redirect('admin/dashboard/index');
				return;
			}

			Session::set_flash('error', 'Tên đăng nhập hoặc mật khẩu không đúng');
			$data['error_message'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
		}

		$this->template->content = View::forge('admin/auth/login', $data);
	}

    /**
     * @return void
     */
    public function action_register()
    {
        $data = array('errors' => array(), 'old' => array());
        $this->template->title = 'Register admin';

        if (Input::method() === 'POST') {
            $username = trim((string) Input::post('username', ''));
            $email = trim((string) Input::post('email', ''));
            $password = (string) Input::post('password', '');
            $full_name = (string) Input::post('full_name', '');

            $data['old'] = array(
                'username' => $username,
                'email' => $email,
                'full_name' => $full_name,
            );

            if ($username === '') {
                $data['errors']['username'] = 'Vui lòng nhập username';
            }
            if ($email === '') {
                $data['errors']['email'] = 'Vui lòng nhập email';
            }
            if ($full_name === '') {
                $data['errors']['full_name'] = 'Vui lòng nhập họ tên';
            }
            if ($password === '') {
                $data['errors']['password'] = 'Vui lòng nhập mật khẩu';
            }

            if (!empty($data['errors'])) {
                $this->template->content = View::forge('admin/auth/register', $data);
                return;
            } else {
                try {
              
                    $user_id = Auth::create_user($username, $password, $email, 1, array('verify_token' => bin2hex(random_bytes(16))));
                    if ($user_id) {
                        DB::query('UPDATE admins SET full_name = :full_name WHERE id = :id')
                            ->parameters(array(':full_name' => $full_name, ':id' => $user_id))
                            ->execute();
                        DB::query('UPDATE admins SET status = :status WHERE id = :id')
                            ->parameters(array(':status' => 'inactive', ':id' => $user_id))
                            ->execute();
                        $this->send_verify_email($email, $username);
                        Session::set_flash('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác nhận.');
                        Response::redirect('admin/login');
                        return;
                    }
                } catch (\Auth\SimpleUserUpdateException $e) {
                    $data['errors']['email'] = $e->getMessage();
                    $this->template->content = View::forge('admin/auth/register', $data);
                    return;
                } catch (\Exception $e) {
                    $data['errors']['general'] = 'Không thể đăng ký: ' . $e->getMessage();
                    $this->template->content = View::forge('admin/auth/register', $data);
                    return;
                }
            }
        }

        $this->template->content = View::forge('admin/auth/register', $data);
    }

    /**
     * Verify email link: admin/verify?email=...&token=...
     */
    public function action_verify()
    {
        $email = urldecode((string) \Fuel\Core\Input::get('email', ''));
        $token = (string) \Fuel\Core\Input::get('token', '');
        if ($email === '' || $token === '') {
            Session::set_flash('error', 'Liên kết xác nhận không hợp lệ.');
            Response::redirect('admin/login');
            return;
        }

        // Read token from profile_fields
        $res = DB::query('SELECT id, profile_fields FROM admins WHERE email = :email')
            ->parameters(array(':email' => $email))
            ->execute();
        $rows = (is_object($res) && method_exists($res, 'as_array')) ? $res->as_array() : (array) $res;
        if (empty($rows)) {
            Session::set_flash('error', 'Tài khoản không tồn tại.');
            Response::redirect('admin/login');
            return;
        }
        $row = $rows[0];
        $fields = array();
        if (!empty($row['profile_fields'])) {
            $fields = json_decode($row['profile_fields'], true) ?: array();
        }
        if (empty($fields['verify_token']) || $fields['verify_token'] !== $token) {
            Session::set_flash('error', 'Token xác nhận không hợp lệ hoặc đã dùng.');
            Response::redirect('admin/login');
            return;
        }

        // Activate account and clear token
        DB::query('UPDATE admins SET status = :status, profile_fields = :pf WHERE id = :id')
            ->parameters(array(
                ':status' => 'active',
                ':pf' => json_encode(array()),
                ':id' => $row['id'],
            ))
            ->execute();

        Session::set_flash('success', 'Xác nhận email thành công. Bạn có thể đăng nhập.');
        Response::redirect('admin/login');
    }

    /**
     * Send verification email
     */
    private function send_verify_email($email, $username)
    {
        try {
            $res = DB::query('SELECT profile_fields FROM admins WHERE email = :email')
                ->parameters(array(':email' => $email))
                ->execute();
            $rows = (is_object($res) && method_exists($res, 'as_array')) ? $res->as_array() : (array) $res;
            $fields = array();
            if (!empty($rows) && !empty($rows[0]['profile_fields'])) {
                $fields = json_decode($rows[0]['profile_fields'], true) ?: array();
            }
            $token = $fields['verify_token'] ?? bin2hex(random_bytes(16));
            $fields['verify_token'] = $token;
            DB::query('UPDATE admins SET profile_fields = :pf WHERE email = :email')
                ->parameters(array(':pf' => json_encode($fields), ':email' => $email))
                ->execute();

            $verify_url = \Uri::create('admin/verify', array(), array('email' => rawurlencode($email), 'token' => $token));
            $subject = 'Xác nhận đăng ký tài khoản';
            $body = 'Chào ' . $username . "\n\n" . 'Vui lòng click vào liên kết sau để xác nhận tài khoản: ' . $verify_url . "\n\n" . 'Nếu không phải bạn thực hiện, vui lòng bỏ qua email này.';

            Package::load('email');
            Email::forge()
                ->to($email)
                ->from($email)
                ->subject($subject)
                ->body($body)
                ->send();
        } catch (\Exception $e) {
            Log::error('Send verify email failed: ' . $e->getMessage());
        }
    }

    public function action_forgot()
    {
        $data = array();
        $this->template->title = 'Forgot password admin';

        $this->template->content = View::forge('admin/auth/forgot-password', $data);
    }

	public function action_logout()
	{
		Session::delete('admin_id');
		Session::delete('admin_username');
		Session::delete('admin_name');
		Session::delete('admin_avatar');
		Session::delete('admin_role');
		
		Auth::logout();
		Session::set_flash('success', 'Đã đăng xuất');
		Response::redirect('admin/login');
	}

    /**
     * Google OAuth redirect
     */
    /**
     * Google OAuth redirect
     */
    public function action_google()
    {
        \Fuel\Core\Response::redirect('auth/google/callback');
    }


    /**
     * Google OAuth callback
     */
    public function action_google_callback()
    {
        $cfg = \Config::get('oauth.google');
        $hybrid_config = array(
            'callback' => $cfg['redirect_uri'],
            'providers' => array(
                'Google' => array(
                    'enabled' => true,
                    'keys' => array('id' => $cfg['client_id'], 'secret' => $cfg['client_secret']),
                    'scope' => 'email profile',
                ),
            ),
        );
        $hybridauth = new \Hybridauth\Hybridauth($hybrid_config);
        $adapter = $hybridauth->authenticate('Google');
        $profile = $adapter->getUserProfile();
        // prevent stuck sessions on subsequent tries
        try { $adapter->disconnect(); } catch (\Exception $e) { /* ignore */ }
        $this->login_or_register_social($profile, 'google');
    }

    /**
     * Facebook OAuth redirect
     */
    public function action_facebook()
    {
        \Fuel\Core\Response::redirect('auth/facebook/callback');
    }


    /**
     * Facebook OAuth callback
     */
    public function action_facebook_callback()
    {
        $cfg = \Config::get('oauth.facebook');
        $hybrid_config = array(
            'callback' => $cfg['redirect_uri'],
            'providers' => array(
                'Facebook' => array(
                    'enabled' => true,
                    'keys' => array('id' => $cfg['client_id'], 'secret' => $cfg['client_secret']),
                    'scope' => 'email',
                ),
            ),
        );
        $hybridauth = new \Hybridauth\Hybridauth($hybrid_config);
        $adapter = $hybridauth->authenticate('Facebook');
        $profile = $adapter->getUserProfile();
        try { $adapter->disconnect(); } catch (\Exception $e) { /* ignore */ }
        $this->login_or_register_social($profile, 'facebook');
    }

    /**
     * Common handler: create or login admin by social profile
     */
    private function login_or_register_social($profile, $provider)
    {
        $email = (string)($profile->email ?? '');
        $name = (string)($profile->displayName ?? '');
        if ($email === '') {
            Session::set_flash('error', 'Không lấy được email từ ' . $provider);
            Response::redirect('admin/login');
            return;
        }

        // Find existing admin
        $admin_result = DB::query('SELECT id, username, full_name, avatar, status FROM admins WHERE email = :email')
            ->parameters(array(':email' => $email))
            ->execute();
        $admin = (is_object($admin_result) && method_exists($admin_result, 'as_array')) ? $admin_result->as_array() : (array) $admin_result;

        if (!empty($admin)) {
            $admin_data = $admin[0];
            if (isset($admin_data['status']) && $admin_data['status'] === 'inactive') {
                Session::set_flash('error', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email để xác nhận.');
                Response::redirect('admin/login');
                return;
            }
            try { \Auth\Auth::force_login((int)$admin_data['id']); } catch (\Exception $e) { /* ignore */ }
            Session::set('admin_id', $admin_data['id']);
            Session::set('admin_username', $admin_data['username']);
            Session::set('admin_name', $admin_data['full_name'] ?: $admin_data['username']);
            Session::set('admin_avatar', $admin_data['avatar']);
            Session::set_flash('success', 'Đăng nhập thành công');
            Response::redirect('admin');
            return;
        }

        // Create new admin with random password, group user=1
        $username = explode('@', $email)[0];
        $password = base64_encode(random_bytes(12));
        try {
            $user_id = Auth::create_user($username, $password, $email, 1, array('full_name' => $name));
            if ($user_id) {
                DB::query('UPDATE admins SET status = :status, full_name = :full_name WHERE id = :id')
                    ->parameters(array(':status' => 'active', ':full_name' => $name, ':id' => $user_id))
                    ->execute();
                try { \Auth\Auth::force_login((int)$user_id); } catch (\Exception $e) { /* ignore */ }
                Session::set('admin_id', $user_id);
                Session::set('admin_username', $username);
                Session::set('admin_name', $name ?: $username);
                Session::set_flash('success', 'Đăng nhập thành công');
                Response::redirect('admin');
                return;
            }
        } catch (\Exception $e) {
            Session::set_flash('error', 'Không thể đăng nhập: ' . $e->getMessage());
        }
        Response::redirect('admin/login');
    }
}
