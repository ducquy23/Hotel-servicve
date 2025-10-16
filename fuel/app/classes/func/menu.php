<?php

class Func_Menu
{
	/**
	 * Lấy dữ liệu menu chung cho tất cả các trang
	 * @return array
	 */
	public static function get_global_menu_data(): array
	{
		$data = array();
		
		try {
			// Get categories for menu
			$categories_sql = 'SELECT id, name, description, icon FROM categories 
				WHERE status = :status 
				ORDER BY name ASC';
			$data['menu_categories'] = \DB::query($categories_sql)
				->parameters(array(':status' => 'active'))
				->execute()
				->as_array();
			
			// Get rooms for menu (grouped by hotel category)
			$rooms_sql = 'SELECT DISTINCT r.room_type, c.name as category_name, c.id as category_id
				FROM rooms r
				LEFT JOIN hotels h ON h.id = r.hotel_id
				LEFT JOIN categories c ON c.id = h.category_id
				WHERE r.status = :status AND h.status = :hotel_status
				ORDER BY c.name, r.room_type';
			$data['menu_rooms'] = \DB::query($rooms_sql)
				->parameters(array(':status' => 'active', ':hotel_status' => 'active'))
				->execute()
				->as_array();
				
		} catch (\Exception $e) {
			// Fallback nếu có lỗi database
			$data['menu_categories'] = array();
			$data['menu_rooms'] = array();
		}
		
		return $data;
	}
	
	/**
	 * Lấy dữ liệu amenities cho section services
	 * @param int $limit
	 * @return array
	 */
	public static function get_amenities_for_home($limit = 6): array
	{
		try {
			$amenities_sql = 'SELECT id, name, description, icon, category FROM amenities 
				WHERE status = :status 
				ORDER BY name ASC 
				LIMIT :limit';
			$result = \DB::query($amenities_sql)
				->parameters(array(':status' => 'active', ':limit' => $limit))
				->execute();
			return $result->as_array();
		} catch (\Exception $e) {
			return array();
		}
	}
}
