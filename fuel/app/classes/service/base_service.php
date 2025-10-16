<?php

use Fuel\Core\DB;

/**
 * Base Service Class
 * Chứa các method chung cho tất cả service
 */
abstract class Service_Base implements Service_Interface
{

	protected $table_name;

	protected $required_fields = array();

	protected $updateable_fields = array();

	/**
	 * Constructor
	 * 
	 * @param string $table_name
	 */
	public function __construct($table_name)
	{
		$this->table_name = $table_name;
	}

	/**
	 * get list pagination và filter
	 */
	public function get_list($filters = array(), $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		foreach ($filters as $field => $value) {
			if ($value !== '' && $value !== null) {
				if (is_array($value)) {
					$placeholders = array();
					foreach ($value as $i => $val) {
						$placeholder = ':' . $field . '_' . $i;
						$placeholders[] = $placeholder;
						$params[$placeholder] = $val;
					}
					$where_conditions[] = $field . ' IN (' . implode(',', $placeholders) . ')';
				} else {
					if (in_array($field, $this->get_searchable_fields())) {
						$where_conditions[] = $field . ' LIKE :' . $field;
						$params[':' . $field] = '%' . $value . '%';
					} else {
						$where_conditions[] = $field . ' = :' . $field;
						$params[':' . $field] = $value;
					}
				}
			}
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}
		$count_query = "SELECT COUNT(*) as total FROM {$this->table_name} " . $where_clause;
		$count_result = DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

        // pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// get data
		$query = "SELECT * FROM {$this->table_name} " . $where_clause . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
        $params[':offset'] = max(0, $offset);

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
     * @param $id
     * @return mixed|null
     */
    public function get_by_id($id)
	{
		$result = DB::query("SELECT * FROM {$this->table_name} WHERE id = :id")
			->parameters(array(':id' => $id))
			->execute();

		return !empty($result) ? $result[0] : null;
	}

    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function create($data)
	{
		$errors = $this->validate($data, false);
		if (!empty($errors)) {
			throw new \Exception(implode(', ', $errors));
		}

		$fields = array();
		$values = array();
		$params = array();

		foreach ($this->get_creatable_fields() as $field) {
			if (isset($data[$field])) {
				$fields[] = $field;
				$values[] = ':' . $field;
				$params[':' . $field] = $data[$field];
			}
		}

		$fields[] = 'created_at';
		$values[] = 'NOW()';
		$fields[] = 'updated_at';
		$values[] = 'NOW()';

		$query = "INSERT INTO {$this->table_name} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
		
		DB::query($query)->parameters($params)->execute();
		
		return DB::query('SELECT LAST_INSERT_ID() AS id')->execute()->current()['id'];
	}

    /**
     * @param $id
     * @param $data
     * @return true
     * @throws Exception
     */
    public function update($id, $data)
	{
		$existing = $this->get_by_id($id);
		if (!$existing) {
			throw new \Exception('Record không tồn tại');
		}

		$errors = $this->validate($data, true);
		if (!empty($errors)) {
			throw new \Exception(implode(', ', $errors));
		}

		$fields = array();
		$params = array(':id' => $id);

		foreach ($this->get_updateable_fields() as $field) {
			if (isset($data[$field])) {
				$fields[] = $field . ' = :' . $field;
				$params[':' . $field] = $data[$field];
			}
		}

		$fields[] = 'updated_at = NOW()';

		$query = "UPDATE {$this->table_name} SET " . implode(', ', $fields) . " WHERE id = :id";
		
		DB::query($query)->parameters($params)->execute();
		
		return true;
	}

    /**
     * @param $id
     * @return true
     * @throws Exception
     */
    public function delete($id)
	{
		$existing = $this->get_by_id($id);
		if (!$existing) {
			throw new \Exception('Record không tồn tại');
		}

		DB::query("DELETE FROM {$this->table_name} WHERE id = :id")
			->parameters(array(':id' => $id))
			->execute();

		return true;
	}

    /**
     * @param $id
     * @return true
     * @throws Exception
     */
    public function toggle_status($id)
	{
		$record = $this->get_by_id($id);
		if (!$record) {
			throw new \Exception('Record không tồn tại');
		}

		$current_status = $record['status'];
		$new_status = ($current_status === 'active') ? 'inactive' : 'active';

		DB::query("UPDATE {$this->table_name} SET status = :status, updated_at = NOW() WHERE id = :id")
			->parameters(array(
				':status' => $new_status,
				':id' => $id
			))
			->execute();

		return true;
	}

    /**
     * @param $data
     * @param $is_update
     * @return array
     */
    public function validate($data, $is_update = false)
	{
		$errors = array();

		foreach ($this->required_fields as $field) {
			if (!isset($data[$field]) || trim($data[$field]) === '') {
				$errors[] = "Trường {$field} là bắt buộc";
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
     * @return array|mixed
     */
    protected function get_creatable_fields()
	{
		return $this->updateable_fields;
	}

    /**
     * @return array|mixed
     */
    protected function get_updateable_fields()
	{
		return $this->updateable_fields;
	}
}
