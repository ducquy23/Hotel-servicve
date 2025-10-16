<?php

class Model_Review extends \Orm\Model
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
		"booking_id" => array(
			"label" => "Booking id",
			"data_type" => "int",
		),
		"rating" => array(
			"label" => "Rating",
			"data_type" => "int",
		),
		"comment" => array(
			"label" => "Comment",
			"data_type" => "text",
		),
		"is_anonymous" => array(
			"label" => "Is anonymous",
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

	protected static $_table_name = 'reviews';

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
		'booking' => array(
			'key_from' => 'booking_id',
			'model_to' => 'Model_Booking',
			'key_to' => 'id',
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
			'pending' => 'Chờ duyệt',
			'approved' => 'Đã duyệt',
			'rejected' => 'Từ chối',
		);
	}

	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			'pending' => 'badge-light-warning',
			'approved' => 'badge-light-success',
			'rejected' => 'badge-light-danger',
		);
		return $classes[$status] ?? 'badge-light-secondary';
	}

	/**
	 * Get rating options
	 */
	public static function get_rating_options()
	{
		return array(
			1 => '1 sao - Rất tệ',
			2 => '2 sao - Tệ',
			3 => '3 sao - Bình thường',
			4 => '4 sao - Tốt',
			5 => '5 sao - Xuất sắc',
		);
	}

	/**
	 * Get rating stars HTML
	 */
	public function get_rating_stars()
	{
		$stars = '';
		for ($i = 1; $i <= 5; $i++) {
			if ($i <= $this->rating) {
				$stars .= '<i class="fas fa-star text-warning"></i>';
			} else {
				$stars .= '<i class="far fa-star text-muted"></i>';
			}
		}
		return $stars;
	}

	/**
	 * Get reviewer name (anonymous or real name)
	 */
	public function get_reviewer_name()
	{
		if ($this->is_anonymous) {
			return 'Khách hàng ẩn danh';
		}
		
		return $this->user ? $this->user->full_name : 'Khách hàng';
	}

	/**
	 * Get reviewer avatar (anonymous or real avatar)
	 */
	public function get_reviewer_avatar()
	{
		if ($this->is_anonymous) {
			return \Uri::base() . 'assets/img/avatars/anonymous.png';
		}
		
		return $this->user ? $this->user->get_avatar_url() : \Uri::base() . 'assets/img/avatars/default-avatar.png';
	}

	/**
	 * Get average rating for hotel
	 */
	public static function get_average_rating_for_hotel($hotel_id)
	{
		$result = \DB::query('SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE hotel_id = :hotel_id AND status = "approved"')
			->parameters(array(':hotel_id' => $hotel_id))
			->execute();
			
		return array(
			'avg_rating' => round($result[0]['avg_rating'], 1),
			'total_reviews' => $result[0]['total_reviews']
		);
	}

	/**
	 * Get average rating for room
	 */
	public static function get_average_rating_for_room($room_id)
	{
		$result = \DB::query('SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE room_id = :room_id AND status = "approved"')
			->parameters(array(':room_id' => $room_id))
			->execute();
			
		return array(
			'avg_rating' => round($result[0]['avg_rating'], 1),
			'total_reviews' => $result[0]['total_reviews']
		);
	}
}