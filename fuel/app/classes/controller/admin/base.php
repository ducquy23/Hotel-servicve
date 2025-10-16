<?php

use Auth\Auth;
use Fuel\Core\Controller_Template;
use Fuel\Core\Request;
use Fuel\Core\Response;

abstract class Controller_Admin_Base extends Controller_Template
{
	public $template = 'layouts/template';

    /**
     * @return void
     */
    public function before()
	{
		parent::before();
		$controller = strtolower(Request::active()->controller);

		if (strpos($controller, 'controller_admin_auth') !== false) {
			return;
		}

		if (!Auth::check()) {
			Response::redirect('admin/login');
		}

        $status = Auth::get('status');

        if ($status === 'inactive') {
            Auth::logout();
            Response::redirect('admin/login?inactive=1');
        }
	}
}
