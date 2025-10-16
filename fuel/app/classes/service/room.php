<?php

/**
 * Service cho quản lý Rooms
 */
class Service_Room extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('rooms');

		$this->required_fields = array('name', 'hotel_id', 'status');

		$this->updateable_fields = array(
			'hotel_id', 'name', 'description', 'price', 'capacity',
			'size', 'bed_type', 'room_type', 'view_type', 'status'
		);
	}

	/**
	 * Validate dữ liệu cho rooms
	 */
	public function validate($data, $is_update = false)
	{
		$errors = parent::validate($data, $is_update);

		// Validate hotel_id
		if (isset($data['hotel_id'])) {
			if (!is_numeric($data['hotel_id']) || $data['hotel_id'] <= 0) {
				$errors[] = 'Vui lòng chọn khách sạn';
			}
		}

		// Validate tên phòng
		if (isset($data['name'])) {
			if (strlen($data['name']) > 255) {
				$errors[] = 'Tên phòng không được vượt quá 255 ký tự';
			}
		}

		// Validate price
		if (isset($data['price'])) {
			if (!is_numeric($data['price']) || $data['price'] < 0) {
				$errors[] = 'Giá phòng phải là số dương';
			}
		}

		// Validate capacity
		if (isset($data['capacity'])) {
			if (!is_numeric($data['capacity']) || $data['capacity'] < 1) {
				$errors[] = 'Sức chứa phải từ 1 người trở lên';
			}
		}

		// Validate room_type
		if (isset($data['room_type']) && $data['room_type']) {
			$valid_types = array('single', 'double', 'family', 'suite');
			if (!in_array($data['room_type'], $valid_types)) {
				$errors[] = 'Loại phòng không hợp lệ';
			}
		}

		// Validate bed_type
		if (isset($data['bed_type']) && $data['bed_type']) {
			$valid_beds = array('single', 'double', 'queen', 'king', 'twin');
			if (!in_array($data['bed_type'], $valid_beds)) {
				$errors[] = 'Loại giường không hợp lệ';
			}
		}

		// Validate view_type
		if (isset($data['view_type']) && $data['view_type']) {
			$valid_views = array('sea', 'city', 'mountain', 'garden', 'pool', 'street');
			if (!in_array($data['view_type'], $valid_views)) {
				$errors[] = 'Loại view không hợp lệ';
			}
		}

		return $errors;
	}

	/**
	 * Lấy danh sách các trường có thể tìm kiếm
	 */
	protected function get_searchable_fields()
	{
		return array('name', 'description');
	}

	/**
	 * Lấy danh sách rooms với thông tin hotel
	 */
	public function get_list_with_hotel($filters = array(), $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		// Xử lý filters
		foreach ($filters as $field => $value) {
			if ($value !== '' && $value !== null) {
				if (in_array($field, $this->get_searchable_fields())) {
					$where_conditions[] = 'r.' . $field . ' LIKE :' . $field;
					$params[':' . $field] = '%' . $value . '%';
				} else {
					$where_conditions[] = 'r.' . $field . ' = :' . $field;
					$params[':' . $field] = $value;
				}
			}
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM rooms r 
						LEFT JOIN hotels h ON r.hotel_id = h.id " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT r.*, h.name as hotel_name 
				  FROM rooms r 
				  LEFT JOIN hotels h ON r.hotel_id = h.id 
				  " . $where_clause . " 
				  ORDER BY r.created_at DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = $offset;

		$rows = \DB::query($query)->parameters($params)->execute();

		return array(
			'rows' => $rows,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $total_pages,
				'total_records' => $total_records,
				'per_page' => $per_page,
				'start' => $offset + 1,
				'end' => min($offset + $per_page, $total_records),
			),
			'filters' => $filters,
		);
	}

	/**
	 * Lấy rooms theo hotel
	 */
	public function get_by_hotel($hotel_id, $page = 1, $per_page = 20)
	{
		$filters = array('hotel_id' => $hotel_id);
		return $this->get_list_with_hotel($filters, $page, $per_page);
	}

	/**
	 * Lấy rooms đang hoạt động
	 */
	public function get_active_rooms()
	{
		return \DB::query('SELECT * FROM rooms WHERE status = "active" ORDER BY name ASC')
			->execute();
	}

	/**
	 * Lấy thống kê rooms
	 */
	public function get_statistics()
	{
		$stats = \DB::query('SELECT 
			COUNT(*) as total,
			SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count,
			SUM(CASE WHEN status = "inactive" THEN 1 ELSE 0 END) as inactive_count,
			AVG(price) as avg_price,
			AVG(capacity) as avg_capacity
			FROM rooms')
			->execute();

		return $stats[0];
	}

	/**
	 * Tìm kiếm rooms theo từ khóa
	 */
	public function search($keyword, $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($keyword) {
			$filters['name'] = $keyword;
		}
		
		return $this->get_list_with_hotel($filters, $page, $per_page);
	}

	/**
	 * Lấy rooms theo giá
	 */
	public function get_by_price_range($min_price, $max_price, $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		if ($min_price > 0) {
			$where_conditions[] = 'r.price >= :min_price';
			$params[':min_price'] = $min_price;
		}

		if ($max_price > 0) {
			$where_conditions[] = 'r.price <= :max_price';
			$params[':max_price'] = $max_price;
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM rooms r 
						LEFT JOIN hotels h ON r.hotel_id = h.id " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT r.*, h.name as hotel_name 
				  FROM rooms r 
				  LEFT JOIN hotels h ON r.hotel_id = h.id 
				  " . $where_clause . " 
				  ORDER BY r.price ASC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = $offset;

		$rows = \DB::query($query)->parameters($params)->execute();

		return array(
			'rows' => $rows,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $total_pages,
				'total_records' => $total_records,
				'per_page' => $per_page,
				'start' => $offset + 1,
				'end' => min($offset + $per_page, $total_records),
			),
		);
	}

	/**
	 * Lấy rooms theo loại phòng
	 */
	public function get_by_room_type($room_type, $page = 1, $per_page = 20)
	{
		$filters = array('room_type' => $room_type);
		return $this->get_list_with_hotel($filters, $page, $per_page);
	}

	/**
	 * Lấy rooms theo sức chứa
	 */
	public function get_by_capacity($min_capacity, $page = 1, $per_page = 20)
	{
		$where_conditions = array('r.capacity >= :min_capacity');
		$params = array(':min_capacity' => $min_capacity);

		$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM rooms r 
						LEFT JOIN hotels h ON r.hotel_id = h.id " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT r.*, h.name as hotel_name 
				  FROM rooms r 
				  LEFT JOIN hotels h ON r.hotel_id = h.id 
				  " . $where_clause . " 
				  ORDER BY r.capacity ASC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = $offset;

		$rows = \DB::query($query)->parameters($params)->execute();

		return array(
			'rows' => $rows,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $total_pages,
				'total_records' => $total_records,
				'per_page' => $per_page,
				'start' => $offset + 1,
				'end' => min($offset + $per_page, $total_records),
			),
		);
	}
}
