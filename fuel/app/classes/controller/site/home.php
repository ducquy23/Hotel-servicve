<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\View;

class Controller_Site_Home extends Controller_Template
{
    public $template = 'layouts/template_site';
	public function action_index()
	{
		$data = array();
		// Latest active hotels (limit 6)
		$hotels_sql = 'SELECT 
			h.id,
			h.name,
			h.description,
			h.address,
			(
				SELECT hi.image_path FROM hotel_images hi 
				WHERE hi.hotel_id = h.id AND hi.is_primary = 1 
				ORDER BY hi.id ASC LIMIT 1
			) AS image_path,
			h.star_rating,
			h.rating
		FROM hotels h
		WHERE h.status = :status
		ORDER BY h.id DESC
		LIMIT :limit';
		$data['home_hotels'] = DB::query($hotels_sql)
			->parameters(array(':status' => 'active', ':limit' => 8))
			->execute();
		$rooms_sql = 'SELECT 
			r.id,
			r.name,
			r.price,
			r.capacity,
			r.size,
			r.bed_type,
			r.room_type,
			h.name AS hotel_name,
			(
				SELECT ri.image_url FROM room_images ri 
				WHERE ri.room_id = r.id AND ri.is_primary = 1 
				ORDER BY ri.id ASC LIMIT 1
			) AS image_url
		FROM rooms r
		LEFT JOIN hotels h ON h.id = r.hotel_id
		WHERE r.status = :status
		ORDER BY r.id DESC
		LIMIT :limit';
		$data['home_rooms'] = DB::query($rooms_sql)
			->parameters(array(':status' => 'active', ':limit' => 4))
			->execute();
		// Latest published blogs (limit 4)
		$blogs_sql = 'SELECT id, title, featured_image, published_at FROM blogs 
			WHERE status = "published" 
			ORDER BY published_at DESC 
			LIMIT :limit';
		$data['home_blogs'] = DB::query($blogs_sql)
			->parameters(array(':limit' => 6))
			->execute();

		$data['amenities'] = Func_Menu::get_amenities_for_home(6);
		$this->template->title = 'Trang chủ';
		$this->template->content = View::forge('site/home/index', $data);
	}

}
