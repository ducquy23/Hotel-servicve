<?php

use Auth\Auth;
use Fuel\Core\DB;
use Fuel\Core\Str;

class Service_Admin extends Service_Base
{
	public function __construct()
	{
		parent::__construct('admins');
		$this->required_fields = array('username', 'email', 'password');
		$this->updateable_fields = array('email', 'full_name', 'group', 'status', 'avatar');
	}

	protected function get_searchable_fields()
	{
		return array('username', 'email', 'full_name');
	}

	public function get_list($filters = array(), $page = 1, $per_page = 20)
	{
		$where_conditions = array();
		$params = array();

		if (isset($filters['keyword']) && $filters['keyword'] !== '') {
			$where_conditions[] = '(username LIKE :kw OR email LIKE :kw OR full_name LIKE :kw)';
			$params[':kw'] = '%' . $filters['keyword'] . '%';
			unset($filters['keyword']);
		}

		foreach ($filters as $field => $value) {
			if ($value === '' || $value === null) continue;
			$where_conditions[] = $field . ' = :' . $field;
			$params[':' . $field] = $value;
		}

		$where_clause = '';
		if (!empty($where_conditions)) {
			$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
		}

		$count_query = "SELECT COUNT(*) as total FROM admins " . $where_clause;
		$total_records = (int) DB::query($count_query)->parameters($params)->execute()->current()['total'];

		$total_pages = max(1, (int) ceil($total_records / $per_page));
		$offset = max(0, ($page - 1) * $per_page);

		$query = "SELECT id, username, email, full_name, `group`, login_hash, last_login, status, avatar, created_at, updated_at
				  FROM admins " . $where_clause . " ORDER BY id DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = (int) $per_page;
		$params[':offset'] = (int) $offset;
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

	public function validate($data, $is_update = false)
	{
		$errors = array();
		if (!$is_update) {
			if (empty($data['username'])) $errors[] = 'Tên đăng nhập là bắt buộc';
			if (empty($data['password'])) $errors[] = 'Mật khẩu là bắt buộc';
		}
		if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Email không hợp lệ';
		}
		return array_merge($errors, parent::validate($data, $is_update));
	}

	public function create($data)
	{
		$errors = $this->validate($data, false);
		if (!empty($errors)) {
			throw new \Exception(implode(', ', $errors));
		}

		$group = isset($data['group']) ? (int) $data['group'] : 100;
		$uid = Auth::create_user($data['username'], $data['password'], $data['email'], $group);
		$fields = array(
			':fn' => isset($data['full_name']) ? $data['full_name'] : null,
			':status' => isset($data['status']) ? $data['status'] : 'active',
			':id' => $uid,
		);
		$sql = 'UPDATE admins SET full_name = :fn, status = :status';
		if (!empty($data['avatar'])) {
			$sql .= ', avatar = :avatar';
			$fields[':avatar'] = $data['avatar'];
		}
		$sql .= ' WHERE id = :id';
		DB::query($sql)->parameters($fields)->execute();
		return $uid;
	}

	public function update($id, $data)
	{
		$existing = $this->get_by_id($id);
		if (!$existing) throw new \Exception('Admin không tồn tại');

		$errors = $this->validate($data, true);
		if (!empty($errors)) throw new \Exception(implode(', ', $errors));

		$fields = array();
		$params = array(':id' => $id);
		foreach (array('email','full_name','group','status','avatar') as $f) {
			if (isset($data[$f])) {
				$fields[] = ($f === 'group' ? '`group`' : $f) . ' = :' . $f;
				$params[':' . $f] = $data[$f];
			}
		}
		if (!empty($data['password'])) {
			$fields[] = 'password = :password';
			$params[':password'] = Auth::hash_password($data['password']);
		}
		if (empty($fields)) return true;
		$sql = 'UPDATE admins SET ' . implode(', ', $fields) . ' WHERE id = :id';
		DB::query($sql)->parameters($params)->execute();
		return true;
	}

	public function reset_password($id)
	{
		$existing = $this->get_by_id($id);
		if (!$existing) throw new \Exception('Admin không tồn tại');
		$newpass = Str::random('alnum', 10);
		$hash = Auth::hash_password($newpass);
		DB::query('UPDATE admins SET password = :p WHERE id = :id')
			->parameters(array(':p' => $hash, ':id' => $id))
			->execute();
		return $newpass;
	}
}



