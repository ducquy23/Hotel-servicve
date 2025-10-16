<?php

/**
 * Service cho quản lý Categories
 */
class Service_Category extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('categories');

		$this->required_fields = array('name', 'status');

		$this->updateable_fields = array(
			'name', 'description', 'icon', 'status'
		);
	}

	/**
	 * Validate dữ liệu cho categories
	 */
	public function validate($data, $is_update = false)
	{
		$errors = parent::validate($data, $is_update);

		// Validate tên loại khách sạn
		if (isset($data['name'])) {
			if (strlen($data['name']) > 255) {
				$errors[] = 'Tên loại khách sạn không được vượt quá 255 ký tự';
			}
		}

		// Validate icon
		if (isset($data['icon']) && $data['icon']) {
			if (strlen($data['icon']) > 255) {
				$errors[] = 'Icon không được vượt quá 255 ký tự';
			}
		}

		// Validate description
		if (isset($data['description']) && $data['description']) {
			if (strlen($data['description']) > 1000) {
				$errors[] = 'Mô tả không được vượt quá 1000 ký tự';
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
	 * Lấy danh sách categories đang hoạt động
	 */
	public function get_active_categories()
	{
		return \DB::query('SELECT * FROM categories WHERE status = "active" ORDER BY name ASC')
			->execute();
	}

	/**
	 * Lấy thống kê categories
	 */
	public function get_statistics()
	{
		$stats = \DB::query('SELECT 
			COUNT(*) as total,
			SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count,
			SUM(CASE WHEN status = "inactive" THEN 1 ELSE 0 END) as inactive_count
			FROM categories')
			->execute();

		return $stats[0];
	}

	/**
	 * Tìm kiếm categories theo từ khóa
	 */
	public function search($keyword, $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($keyword) {
			$filters['name'] = $keyword;
		}
		
		return $this->get_list($filters, $page, $per_page);
	}

	/**
	 * Kiểm tra xem category có đang được sử dụng bởi hotels không
	 */
	public function is_used_by_hotels($category_id)
	{
		$count = \DB::query('SELECT COUNT(*) as total FROM hotels WHERE category_id = :id')
			->parameters(array(':id' => $category_id))
			->execute();
		
		return $count[0]['total'] > 0;
	}

	/**
	 * Lấy số lượng hotels sử dụng category
	 */
	public function get_hotels_count($category_id)
	{
		$count = \DB::query('SELECT COUNT(*) as total FROM hotels WHERE category_id = :id')
			->parameters(array(':id' => $category_id))
			->execute();
		
		return (int) $count[0]['total'];
	}

	/**
	 * Xóa category (chỉ khi không có hotels nào sử dụng)
	 */
	public function delete($id)
	{
		if ($this->is_used_by_hotels($id)) {
			$hotels_count = $this->get_hotels_count($id);
			throw new Exception("Không thể xóa loại khách sạn này vì đang được sử dụng bởi {$hotels_count} khách sạn");
		}

		return parent::delete($id);
	}

	/**
	 * Lấy categories với số lượng hotels
	 */
	public function get_list_with_hotels_count($filters = array(), $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		// Xử lý filters
		foreach ($filters as $field => $value) {
			if ($value !== '' && $value !== null) {
				if (in_array($field, $this->get_searchable_fields())) {
					$where_conditions[] = 'c.' . $field . ' LIKE :' . $field;
					$params[':' . $field] = '%' . $value . '%';
				} else {
					$where_conditions[] = 'c.' . $field . ' = :' . $field;
					$params[':' . $field] = $value;
				}
			}
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM categories c " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu với số lượng hotels
		$query = "SELECT c.*, COUNT(h.id) as hotels_count 
				  FROM categories c 
				  LEFT JOIN hotels h ON c.id = h.category_id 
				  " . $where_clause . " 
				  GROUP BY c.id 
				  ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset";
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
	 * Lấy categories theo icon
	 */
	public function get_by_icon($icon, $page = 1, $per_page = 20)
	{
		$filters = array('icon' => $icon);
		return $this->get_list($filters, $page, $per_page);
	}

	/**
	 * Lấy categories có icon
	 */
	public function get_with_icons($page = 1, $per_page = 20)
	{
		$where_conditions = array("icon IS NOT NULL AND icon != ''");
		$params = array();

		$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM categories " . $where_clause;
		$count_result = \DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT * FROM categories 
				  " . $where_clause . " 
				  ORDER BY name ASC LIMIT :limit OFFSET :offset";
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
