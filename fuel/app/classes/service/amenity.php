<?php

use Fuel\Core\DB;

/**
 * Service cho quản lý Amenities
 */
class Service_Amenity extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('amenities');

		$this->required_fields = array('name', 'category', 'status');

		$this->updateable_fields = array(
			'name', 'description', 'icon', 'category', 'status',
			'price', 'service_type', 'is_24h', 'operating_hours'
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

		// Validate tên tiện ích
		if (isset($data['name'])) {
			if (strlen($data['name']) > 100) {
				$errors[] = 'Tên tiện ích không được vượt quá 100 ký tự';
			}
		}

		// Validate mô tả
		if (isset($data['description']) && $data['description']) {
			if (strlen($data['description']) > 1000) {
				$errors[] = 'Mô tả không được vượt quá 1000 ký tự';
			}
		}

		// Validate icon
		if (isset($data['icon']) && $data['icon']) {
			if (strlen($data['icon']) > 50) {
				$errors[] = 'Icon không được vượt quá 50 ký tự';
			}
		}

		// Validate category
		if (isset($data['category'])) {
			if (strlen($data['category']) > 50) {
				$errors[] = 'Nhóm không được vượt quá 50 ký tự';
			}
		}

		// Validate status
		if (isset($data['status'])) {
			$valid_statuses = array('active', 'inactive');
			if (!in_array($data['status'], $valid_statuses)) {
				$errors[] = 'Trạng thái không hợp lệ';
			}
		}

		return $errors;
	}

    /**
     * @return string[]
     */
    protected function get_searchable_fields()
	{
		return array('name', 'description');
	}

    /**
     * @param $id
     * @return true
     * @throws Exception
     */
    public function delete($id)
	{
		$amenity = $this->get_by_id($id);
		if (!$amenity) {
			throw new Exception('Không tìm thấy tiện ích');
		}
		$used_count = DB::query('SELECT COUNT(*) AS count FROM hotel_amenities WHERE amenity_id = :id')
			->parameters(array(':id' => $id))
			->execute()
			->current()['count'];

		if ((int) $used_count > 0) {
			throw new Exception('Không thể xóa vì có ' . (int)$used_count . ' khách sạn đang sử dụng');
		}

		return parent::delete($id);
	}

    /**
     * @param $category
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_category($category, $page = 1, $per_page = 20)
	{
		$filters = array('category' => $category);
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $filters
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_active_amenities($filters = array(), $page = 1, $per_page = 20)
	{
		$filters['status'] = 'active';
		return $this->get_list($filters, $page, $per_page);
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
			COUNT(DISTINCT category) as categories_count
			FROM amenities')
			->execute();

		return $stats[0];
	}

    /**
     * @return object
     */
    public function get_categories_with_count()
	{
		$query = "SELECT category, COUNT(*) as count 
				  FROM amenities 
				  WHERE status = 'active' 
				  GROUP BY category 
				  ORDER BY count DESC, category ASC";
		
		return DB::query($query)->execute();
	}

    /**
     * @param $limit
     * @return object
     */
    public function get_most_used_amenities($limit = 10)
	{
		$query = "SELECT a.*, COUNT(ha.hotel_id) as usage_count
				  FROM amenities a
				  LEFT JOIN hotel_amenities ha ON a.id = ha.amenity_id
				  WHERE a.status = 'active'
				  GROUP BY a.id
				  ORDER BY usage_count DESC, a.name ASC
				  LIMIT :limit";
		
		return DB::query($query)
			->parameters(array(':limit' => $limit))
			->execute();
	}

    /**
     * @return object
     */
    public function get_unused_amenities()
	{
		$query = "SELECT a.*
				  FROM amenities a
				  LEFT JOIN hotel_amenities ha ON a.id = ha.amenity_id
				  WHERE a.status = 'active' AND ha.amenity_id IS NULL
				  ORDER BY a.name ASC";
		
		return DB::query($query)->execute();
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
		
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $hotel_id
     * @return object
     */
    public function get_by_hotel($hotel_id)
	{
		$query = "SELECT a.*
				  FROM amenities a
				  INNER JOIN hotel_amenities ha ON a.id = ha.amenity_id
				  WHERE ha.hotel_id = :hotel_id AND a.status = 'active'
				  ORDER BY a.category ASC, a.name ASC";
		
		return DB::query($query)
			->parameters(array(':hotel_id' => $hotel_id))
			->execute();
	}

    /**
     * @param $ids
     * @param $status
     * @return true
     * @throws Exception
     */
    public function bulk_update_status($ids, $status)
	{
		if (empty($ids)) {
			throw new Exception('Không có amenity nào được chọn');
		}

		$valid_statuses = array('active', 'inactive');
		if (!in_array($status, $valid_statuses)) {
			throw new Exception('Trạng thái không hợp lệ');
		}

		$placeholders = implode(',', array_fill(0, count($ids), '?'));
		$query = "UPDATE amenities SET status = ?, updated_at = NOW() WHERE id IN ($placeholders)";
		
		$params = array_merge(array($status), $ids);
		
		DB::query($query)->parameters($params)->execute();
		
		return true;
	}

    /**
     * @param $ids
     * @return true
     * @throws Exception
     */
    public function bulk_delete($ids)
	{
		if (empty($ids)) {
			throw new Exception('Không có amenity nào được chọn');
		}
		foreach ($ids as $id) {
			$used_count = DB::query('SELECT COUNT(*) AS count FROM hotel_amenities WHERE amenity_id = :id')
				->parameters(array(':id' => $id))
				->execute()
				->current()['count'];

			if ((int) $used_count > 0) {
				throw new Exception("Không thể xóa amenity ID $id vì đang được sử dụng bởi $used_count khách sạn");
			}
		}

		$placeholders = implode(',', array_fill(0, count($ids), '?'));
		$query = "DELETE FROM amenities WHERE id IN ($placeholders)";
		
		DB::query($query)->parameters($ids)->execute();
		
		return true;
	}
}
