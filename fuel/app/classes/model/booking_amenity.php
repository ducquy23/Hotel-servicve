<?php

class Model_Booking_Amenity extends \Orm\Model
{
	protected static $_table_name = 'booking_amenities';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'booking_id',
		'amenity_id',
		'quantity',
		'unit_price',
		'total_price',
		'scheduled_date',
		'scheduled_time',
		'status',
		'created_at',
		'updated_at',
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
	
	// Relationships
	protected static $_belongs_to = array(
		'booking' => array(
			'key_from' => 'booking_id',
			'model_to' => 'Model_Booking',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
		'amenity' => array(
			'key_from' => 'amenity_id',
			'model_to' => 'Model_Amenity',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);
	
	// Constants
	const STATUS_PENDING = 'pending';
	const STATUS_CONFIRMED = 'confirmed';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
	
	/**
	 * Get booking amenities by booking ID
	 */
	public static function get_by_booking($booking_id)
	{
		return self::query()
			->where('booking_id', $booking_id)
			->order_by('created_at', 'ASC')
			->get();
	}
	
	/**
	 * Get pending amenities
	 */
	public static function get_pending()
	{
		return self::query()
			->where('status', self::STATUS_PENDING)
			->order_by('scheduled_date', 'ASC')
			->get();
	}
	
	/**
	 * Calculate total price
	 */
	public function calculate_total_price()
	{
		$this->total_price = $this->unit_price * $this->quantity;
		return $this->total_price;
	}
	
	/**
	 * Get formatted total price
	 */
	public function get_formatted_total_price()
	{
		return number_format($this->total_price, 0, ',', '.') . ' VNĐ';
	}
	
	/**
	 * Get status badge class
	 */
	public function get_status_badge_class()
	{
		$classes = array(
			self::STATUS_PENDING => 'badge-warning',
			self::STATUS_CONFIRMED => 'badge-info',
			self::STATUS_COMPLETED => 'badge-success',
			self::STATUS_CANCELLED => 'badge-danger',
		);
		
		return isset($classes[$this->status]) ? $classes[$this->status] : 'badge-secondary';
	}
	
	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			self::STATUS_PENDING => 'Chờ xác nhận',
			self::STATUS_CONFIRMED => 'Đã xác nhận',
			self::STATUS_COMPLETED => 'Hoàn thành',
			self::STATUS_CANCELLED => 'Đã hủy',
		);
	}
}
