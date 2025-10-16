<?php

use Fuel\Core\DB;

/**
 * Service cho quản lý Services
 */
class Service_Service extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('services');
		$this->required_fields = array('name', 'status');
		$this->updateable_fields = array('name', 'description', 'icon', 'price', 'status');
	}


    /**
     * @param $data
     * @param $is_update
     * @return array
     */
    public function validate($data, $is_update = false)
	{
		$errors = parent::validate($data, $is_update);
		if (isset($data['name'])) {
			if (strlen($data['name']) > 255) {
				$errors[] = 'Tên dịch vụ không được vượt quá 255 ký tự';
			}
            // check trùng tên khi thêm mới
			if (!$is_update) {
				$existing = DB::query('SELECT id FROM services WHERE name = :name')
					->parameters(array(':name' => $data['name']))
					->execute()->as_array();

                if (count($existing) > 0) {
                    $errors[] = 'Tên dịch vụ đã tồn tại';
                }
			}
		}

		// Validate mô tả
		if (isset($data['description']) && strlen($data['description']) > 1000) {
			$errors[] = 'Mô tả không được vượt quá 1000 ký tự';
		}

		// Validate icon
		if (isset($data['icon']) && strlen($data['icon']) > 100) {
			$errors[] = 'Icon không được vượt quá 100 ký tự';
		}

		// Validate giá
		if (isset($data['price'])) {
			if (!is_numeric($data['price']) || $data['price'] < 0) {
				$errors[] = 'Giá phải là số dương';
			}
		}

		// Validate trạng thái
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
     * @param $status
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_list_by_status($status = '', $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($status) {
			$filters['status'] = $status;
		}
		
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @return object
     */
    public function get_active_services()
	{
		return DB::query('SELECT * FROM services WHERE status = "active" ORDER BY name ASC')
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
			AVG(price) as avg_price
			FROM services')
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
			$filters['name'] = $keyword; // Sẽ được xử lý như searchable field
		}
		
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $category
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_category($category = '', $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($category) {
			$filters['category'] = $category;
		}
		
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $ids
     * @param $status
     * @return true
     * @throws Exception
     */
    public function bulk_update_status($ids, $status)
	{
		if (empty($ids) || !is_array($ids)) {
			throw new \Exception('Danh sách ID không hợp lệ');
		}

		$valid_statuses = array('active', 'inactive');
		if (!in_array($status, $valid_statuses)) {
			throw new \Exception('Trạng thái không hợp lệ');
		}

		$placeholders = array();
		$params = array(':status' => $status);
		
		foreach ($ids as $i => $id) {
			$placeholder = ':id_' . $i;
			$placeholders[] = $placeholder;
			$params[$placeholder] = $id;
		}

		$query = "UPDATE {$this->table_name} SET status = :status, updated_at = NOW() WHERE id IN (" . implode(',', $placeholders) . ")";
		
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
		if (empty($ids) || !is_array($ids)) {
			throw new \Exception('Danh sách ID không hợp lệ');
		}

		$placeholders = array();
		$params = array();
		
		foreach ($ids as $i => $id) {
			$placeholder = ':id_' . $i;
			$placeholders[] = $placeholder;
			$params[$placeholder] = $id;
		}

		$query = "DELETE FROM {$this->table_name} WHERE id IN (" . implode(',', $placeholders) . ")";
		
		DB::query($query)->parameters($params)->execute();
		
		return true;
	}
}