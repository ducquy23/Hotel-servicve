<?php

use Fuel\Core\Input;
use Fuel\Core\Model_Blog;

class Presenter_Admin_Blogs_Index extends \Fuel\Core\Presenter
{
	/**
	 * Prepare data for the view
	 */
	public function view()
	{
		// Lấy tham số filter từ Input
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
		$service = new \Service_Blog();
		$result = $service->get_list($filters, $page, $per_page);

		// Prepare view data
		$this->rows = $result['rows'];
		$this->status = $status;
		$this->category = $category;
		$this->keyword = $keyword;
		$this->pagination = array(
			'current_page' => $page,
			'total_pages' => $result['pagination']['total_pages'],
			'total_records' => $result['pagination']['total_records'],
			'per_page' => $per_page,
			'start' => $result['pagination']['start'],
			'end' => $result['pagination']['end'],
		);
		
		// Additional data for view
		$this->categories = Model_Blog::get_category_options();
		$this->status_options = Model_Blog::get_status_options();
		
		// Statistics for dashboard
		$this->stats = array(
			'total_blogs' => $result['pagination']['total_records'],
			'published_blogs' => count(array_filter($result['rows'], function($row) {
				return $row['status'] === 'published';
			})),
			'draft_blogs' => count(array_filter($result['rows'], function($row) {
				return $row['status'] === 'draft';
			}))
		);
	}
}
