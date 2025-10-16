<?php

class Controller_Admin_Dashboard extends Controller_Admin_Base
{
	public function action_index()
	{
		$this->template->title = 'Admin Dashboard';
		$this->template->content = View::forge('admin/dashboard/index');
	}
}
