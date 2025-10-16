<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"username" => array(
			"label" => "Username",
			"data_type" => "varchar",
		),
		"email" => array(
			"label" => "Email",
			"data_type" => "varchar",
		),
		"password" => array(
			"label" => "Password",
			"data_type" => "varchar",
		),
		"full_name" => array(
			"label" => "Full name",
			"data_type" => "varchar",
		),
		"phone" => array(
			"label" => "Phone",
			"data_type" => "varchar",
		),
		"avatar" => array(
			"label" => "Avatar",
			"data_type" => "varchar",
		),
		"date_of_birth" => array(
			"label" => "Date of birth",
			"data_type" => "date",
		),
		"gender" => array(
			"label" => "Gender",
			"data_type" => "enum",
		),
		"address" => array(
			"label" => "Address",
			"data_type" => "text",
		),
		"is_verified" => array(
			"label" => "Is verified",
			"data_type" => "tinyint",
		),
		"status" => array(
			"label" => "Status",
			"data_type" => "enum",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "datetime",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "datetime",
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => true,
		),
	);

	protected static $_table_name = 'users';

	protected static $_primary_key = array('id');

	protected static $_has_many = array(
		'bookings' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Booking',
			'key_to' => 'user_id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
		'reviews' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Review',
			'key_to' => 'user_id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get gender options
	 */
	public static function get_gender_options()
	{
		return array(
			'male' => 'Nam',
			'female' => 'Nữ',
			'other' => 'Khác',
		);
	}

	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			'active' => 'Hoạt động',
			'inactive' => 'Không hoạt động',
			'banned' => 'Bị cấm',
		);
	}

	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			'active' => 'badge-light-success',
			'inactive' => 'badge-light-secondary',
			'banned' => 'badge-light-danger',
		);
		return $classes[$status] ?? 'badge-light-secondary';
	}

	/**
	 * Get verification badge class
	 */
	public static function get_verification_badge_class($is_verified)
	{
		return $is_verified ? 'badge-light-success' : 'badge-light-warning';
	}

	/**
	 * Get verification text
	 */
	public static function get_verification_text($is_verified)
	{
		return $is_verified ? 'Đã xác thực' : 'Chưa xác thực';
	}

	/**
	 * Get age from date of birth
	 */
	public function get_age()
	{
		if (!$this->date_of_birth) {
			return null;
		}
		
		$birth = new DateTime($this->date_of_birth);
		$now = new DateTime();
		return $now->diff($birth)->y;
	}

	/**
	 * Get avatar URL or default
	 */
	public function get_avatar_url()
	{
		if ($this->avatar && file_exists(DOCROOT . $this->avatar)) {
			return \Uri::base() . $this->avatar;
		}
		return \Uri::base() . 'assets/img/avatars/default-avatar.png';
	}

	/**
	 * Get formatted phone number
	 */
	public function get_formatted_phone()
	{
		if (!$this->phone) {
			return 'N/A';
		}
		
		// Format Vietnamese phone number
		$phone = preg_replace('/[^0-9]/', '', $this->phone);
		if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
			return substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7);
		}
		return $this->phone;
	}
}