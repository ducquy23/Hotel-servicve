<?php

use Fuel\Core\DB;

/**
 * Service cho quản lý Hotels
 * Ví dụ về cách áp dụng service layer cho module khác
 */
class Service_Hotel extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('hotels');

		$this->required_fields = array('name', 'status');

		$this->updateable_fields = array(
			'name', 'description', 'address', 'city', 'country', 
			'phone', 'email', 'rating', 'status', 'category_id',
			'star_rating', 'website', 'latitude', 'longitude',
			'province_id', 'ward_id',
			'checkin_time', 'checkout_time',
			'manager_name', 'manager_phone',
			'wifi_password', 'facebook', 'instagram',
			'is_featured', 'cancellation_policy'
		);
	}

    /**
     * @param $data
     * @param $is_update
     * @return array
     */
    public function validate($data, $is_update = false)
	{
		$errors = parent::validate($data, $is_update);

		// Validate tên khách sạn
		if (isset($data['name'])) {
			if (strlen($data['name']) > 255) {
				$errors[] = 'Tên khách sạn không được vượt quá 255 ký tự';
			}
		}

		// Validate email
		if (isset($data['email']) && $data['email']) {
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'Email không hợp lệ';
			}
		}

		// Validate rating
		if (isset($data['rating'])) {
			if (!is_numeric($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
				$errors[] = 'Rating phải từ 1 đến 5 sao';
			}
		}

		// Validate star_rating
		if (isset($data['star_rating'])) {
			if (!is_numeric($data['star_rating']) || $data['star_rating'] < 1 || $data['star_rating'] > 5) {
				$errors[] = 'Hạng sao phải từ 1 đến 5';
			}
		}

		// Validate website
		if (isset($data['website']) && $data['website']) {
			if (!filter_var($data['website'], FILTER_VALIDATE_URL)) {
				$errors[] = 'Website không hợp lệ';
			}
		}

		// Validate coordinates
		if (isset($data['latitude']) && $data['latitude'] !== null && $data['latitude'] !== '') {
			if (!is_numeric($data['latitude']) || $data['latitude'] < -90 || $data['latitude'] > 90) {
				$errors[] = 'Latitude không hợp lệ';
			}
		}

		if (isset($data['longitude']) && $data['longitude'] !== null && $data['longitude'] !== '') {
			if (!is_numeric($data['longitude']) || $data['longitude'] < -180 || $data['longitude'] > 180) {
				$errors[] = 'Longitude không hợp lệ';
			}
		}

		return $errors;
	}

    /**
     * @return string[]
     */
    protected function get_searchable_fields()
	{
		return array('name', 'description', 'address', 'city');
	}

    /**
     * @param $filters
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_list_with_province($filters = array(), $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		// Xử lý filters
		foreach ($filters as $field => $value) {
			if ($value !== '' && $value !== null) {
				if (in_array($field, $this->get_searchable_fields())) {
					$where_conditions[] = 'h.' . $field . ' LIKE :' . $field;
					$params[':' . $field] = '%' . $value . '%';
				} else {
					$where_conditions[] = 'h.' . $field . ' = :' . $field;
					$params[':' . $field] = $value;
				}
			}
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM hotels h 
						LEFT JOIN provinces p ON h.province_id = p.id 
						LEFT JOIN categories c ON h.category_id = c.id " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT h.*, p.name as province_name, c.name as category_name, c.icon as category_icon 
				  FROM hotels h 
				  LEFT JOIN provinces p ON h.province_id = p.id 
				  LEFT JOIN categories c ON h.category_id = c.id 
				  " . $where_clause . " 
				  ORDER BY h.created_at DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = $offset;

		$rows = DB::query($query)->parameters($params)->execute();

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
     * @param $category_id
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_category($category_id, $page = 1, $per_page = 20)
	{
		$filters = array('category_id' => $category_id);
		return $this->get_list_with_province($filters, $page, $per_page);
	}

    /**
     * @param $province_id
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_province($province_id, $page = 1, $per_page = 20)
	{
		$filters = array('province_id' => $province_id);
		return $this->get_list_with_province($filters, $page, $per_page);
	}

    /**
     * @return object
     */
    public function get_active_hotels()
	{
		return DB::query('SELECT * FROM hotels WHERE status = "active" ORDER BY name ASC')
			->execute();
	}

    /**
     * @return mixed
     */
    public function get_statistics()
	{
		$stats = DB::query('SELECT 
			COUNT(*) as total,
			SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count,
			SUM(CASE WHEN status = "inactive" THEN 1 ELSE 0 END) as inactive_count,
			AVG(rating) as avg_rating,
			AVG(star_rating) as avg_star_rating
			FROM hotels')
			->execute();

		return $stats[0];
	}

    /**
     * @param $keyword
     * @param $page
     * @param $per_page
     * @return array
     */
    public function search($keyword, $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($keyword) {
			$filters['name'] = $keyword;
		}
		
		return $this->get_list_with_province($filters, $page, $per_page);
	}

    /**
     * @param $latitude
     * @param $longitude
     * @param $radius_km
     * @param $limit
     * @return mixed
     */
    public function get_nearby_hotels($latitude, $longitude, $radius_km = 10, $limit = 10)
	{
		$query = "SELECT *, 
				  (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) * 
				  cos(radians(longitude) - radians(:lng)) + sin(radians(:lat)) * 
				  sin(radians(latitude)))) AS distance 
				  FROM hotels 
				  WHERE latitude IS NOT NULL AND longitude IS NOT NULL 
				  AND status = 'active'
				  HAVING distance < :radius 
				  ORDER BY distance 
				  LIMIT :limit";

		return DB::query($query)
			->parameters(array(
				':lat' => $latitude,
				':lng' => $longitude,
				':radius' => $radius_km,
				':limit' => $limit
			))
			->execute();
	}
}
