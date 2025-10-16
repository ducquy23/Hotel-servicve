<?php

class Model_Booking extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"user_id" => array(
			"label" => "User id",
			"data_type" => "int",
		),
		"hotel_id" => array(
			"label" => "Hotel id",
			"data_type" => "int",
		),
		"room_id" => array(
			"label" => "Room id",
			"data_type" => "int",
		),
		"check_in" => array(
			"label" => "Check in",
			"data_type" => "date",
		),
		"check_out" => array(
			"label" => "Check out",
			"data_type" => "date",
		),
		"guest_count" => array(
			"label" => "Guest count",
			"data_type" => "int",
		),
		"booking_reference" => array(
			"label" => "Booking reference",
			"data_type" => "varchar",
		),
		"total_amount" => array(
			"label" => "Total amount",
			"data_type" => "decimal",
		),
		"status" => array(
			"label" => "Status",
			"data_type" => "enum",
		),
		"cancellation_reason" => array(
			"label" => "Cancellation reason",
			"data_type" => "text",
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

	protected static $_table_name = 'bookings';

	protected static $_primary_key = array('id');

	protected static $_belongs_to = array(
		'user' => array(
			'key_from' => 'user_id',
			'model_to' => 'Model_User',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
		'hotel' => array(
			'key_from' => 'hotel_id',
			'model_to' => 'Model_Hotel',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
		'room' => array(
			'key_from' => 'room_id',
			'model_to' => 'Model_Room',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'reviews' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Review',
			'key_to' => 'booking_id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			'pending' => 'Chờ xác nhận',
			'confirmed' => 'Đã xác nhận',
			'checked_in' => 'Đã check-in',
			'checked_out' => 'Đã check-out',
			'cancelled' => 'Đã hủy',
			'no_show' => 'Không đến',
		);
	}

	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			'pending' => 'badge-light-warning',
			'confirmed' => 'badge-light-info',
			'checked_in' => 'badge-light-success',
			'checked_out' => 'badge-light-primary',
			'cancelled' => 'badge-light-danger',
			'no_show' => 'badge-light-secondary',
		);
		return $classes[$status] ?? 'badge-light-secondary';
	}

	/**
	 * Generate booking reference
	 */
	public static function generate_booking_reference()
	{
		$prefix = 'BK';
		$date = date('Ymd');
		$random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
		return $prefix . $date . $random;
	}

	/**
	 * Get formatted total amount
	 */
	public function get_formatted_total_amount()
	{
		return number_format($this->total_amount, 0, ',', '.') . ' VNĐ';
	}

	/**
	 * Get number of nights
	 */
	public function get_nights_count()
	{
		$check_in = new DateTime($this->check_in);
		$check_out = new DateTime($this->check_out);
		return $check_out->diff($check_in)->days;
	}

	/**
	 * Check if booking can be cancelled
	 */
	public function can_be_cancelled()
	{
		$check_in = new DateTime($this->check_in);
		$now = new DateTime();
		$hours_until_checkin = $now->diff($check_in)->h + ($now->diff($check_in)->days * 24);
		
		return in_array($this->status, array('pending', 'confirmed')) && $hours_until_checkin >= 24;
	}
}