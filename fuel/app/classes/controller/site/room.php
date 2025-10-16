<?php

class Controller_Site_Room extends Controller_Template
{
    public $template = 'layouts/template_site';

	public function action_index()
	{
		$data = array();
		$per_page = 9;
		$page = (int) \Input::get('page', 1);
		if ($page < 1) {
			$page = 1;
		}
		$offset = ($page - 1) * $per_page;

		$count_query = 'SELECT COUNT(*) AS total FROM rooms r WHERE r.status = :status';
		$count_result = \DB::query($count_query)
			->parameters(array(':status' => 'active'))
			->execute();
		$total = (int) $count_result[0]['total'];

		$sql = 'SELECT 
			r.id,
			r.name,
			r.price,
			r.capacity,
			r.size,
			r.bed_type,
			r.room_type,
			h.name AS hotel_name,
			(
				SELECT ri.image_url 
				FROM room_images ri 
				WHERE ri.room_id = r.id AND ri.is_primary = 1 
				ORDER BY ri.id ASC 
				LIMIT 1
			) AS image_url
		FROM rooms r
		LEFT JOIN hotels h ON h.id = r.hotel_id
		WHERE r.status = :status
		ORDER BY r.id DESC
		LIMIT :limit OFFSET :offset';

		$params = array(
			':status' => 'active',
			':limit' => (int) $per_page,
			':offset' => (int) $offset,
		);
		$rooms = \DB::query($sql)->parameters($params)->execute();

		// Breadcrumb
		$data['breadcrumb_title'] = 'Phòng';
		$data['breadcrumb_items'] = array(
			array('label' => 'Home', 'url' => \Uri::base()),
			array('label' => 'Phòng')
		);

		// Paging data
		$data['rooms'] = $rooms;
		$data['page'] = $page;
		$data['per_page'] = $per_page;
		$data['total'] = $total;
		$total_pages = (int) ceil($total / $per_page);
		$data['total_pages'] = $total_pages;
		$data['has_prev'] = $page > 1;
		$data['has_next'] = $page < $total_pages;
		$data['prev_page'] = $page > 1 ? $page - 1 : null;
		$data['next_page'] = $page < $total_pages ? $page + 1 : null;

		$this->template->title = 'Danh sách phòng';
		$this->template->content = View::forge('site/room/index', $data);
	}
    public function action_detail($id = null)
    {
        $data["subnav"] = array('index'=> 'active' );

        $this->template->title = 'Chi tiết phòng';
        $this->template->content = View::forge('site/room/detail', $data);
    }

}
