<?php

class Controller_Site_About extends Controller_Template
{
    public $template = 'layouts/template_site';

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Site/about &raquo; Index';
		$this->template->content = View::forge('site/about/index', $data);
	}

}
