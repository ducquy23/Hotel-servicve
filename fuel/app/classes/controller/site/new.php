<?php

class Controller_Site_New extends Controller_Template
{
	public $template = 'layouts/template_site';

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );

		// Pagination params
		$per_page = 6;
		$page = (int) \Input::get('page', 1);
		if ($page < 1) {
			$page = 1;
		}
		$offset = ($page - 1) * $per_page;

		// Tổng số bài xuất bản
		$total = Model_Blog::query()
			->where('status', Model_Blog::STATUS_PUBLISHED)
			->count();

		// Danh sách theo trang
		$blogs = Model_Blog::query()
			->where('status', Model_Blog::STATUS_PUBLISHED)
			->order_by('published_at', 'DESC')
			->limit($per_page)
			->offset($offset)
			->get();
		$data['breadcrumb_title'] = 'Tin tức';
		$data['breadcrumb_items'] = array(
			array('label' => 'Home', 'url' => \Uri::base()),
			array('label' => 'Tin tức')
		);

		$data['blogs'] = $blogs;
		$data['page'] = $page;
		$data['per_page'] = $per_page;
		$data['total'] = $total;
		$total_pages = (int) ceil($total / $per_page);
		$data['total_pages'] = $total_pages;
		$data['has_prev'] = $page > 1;
		$data['has_next'] = $page < $total_pages;
		$data['prev_page'] = $page > 1 ? $page - 1 : null;
		$data['next_page'] = $page < $total_pages ? $page + 1 : null;

		$this->template->title = 'Tin tức';
		$this->template->content = View::forge('site/new/index', $data);
	}

	public function action_detail($id)
	{
		$id = (int) $id;
		$blog = Model_Blog::find($id);
		if (!$blog || $blog->status !== Model_Blog::STATUS_PUBLISHED) {
			return Response::forge(\View::forge('welcome/404'), 404);
		}

		$related = Model_Blog::query()
			->where('status', Model_Blog::STATUS_PUBLISHED)
			->where('id', '!=', $id)
			->where('category', $blog->category)
			->order_by('published_at', 'DESC')
			->limit(3)
			->get();

		$data = array();
		$data['blog'] = $blog;
		$data['related'] = $related;
		$data['breadcrumb_title'] = 'Tin tức';
		$data['breadcrumb_items'] = array(
			array('label' => 'Home', 'url' => \Uri::base()),
			array('label' => 'Tin tức', 'url' => \Uri::base().'new'),
			array('label' => $blog->title),
		);

		$this->template->title = $blog->title;
		$this->template->content = View::forge('site/new/detail', $data);
	}

}
