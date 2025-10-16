<?php

class Model_Booking_Room extends \Orm\Model
{
	protected static $_table_name = 'booking_rooms';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'booking_id',
		'room_id',
		'quantity',
		'price_per_night',
		'total_nights',
		'total_price',
		'guest_requests',
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
		'room' => array(
			'key_from' => 'room_id',
			'model_to' => 'Model_Room',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get booking rooms by booking ID
	 */
	public static function get_by_booking($booking_id)
	{
		return self::query()
			->where('booking_id', $booking_id)
			->order_by('id', 'ASC')
			->get();
	}
	
	/**
	 * Calculate total price
	 */
	public function calculate_total_price()
	{
		$this->total_price = $this->price_per_night * $this->total_nights * $this->quantity;
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
	 * Get formatted price per night
	 */
	public function get_formatted_price_per_night()
	{
		return number_format($this->price_per_night, 0, ',', '.') . ' VNĐ';
	}
	
	/**
	 * Get room details summary
	 */
	public function get_room_summary()
	{
		return $this->room->name . ' x' . $this->quantity . ' (' . $this->total_nights . ' đêm)';
	}
}
