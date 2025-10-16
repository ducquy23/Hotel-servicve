<?php

class Model_Room_Availability extends \Orm\Model
{
	protected static $_table_name = 'room_availability';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'room_id',
		'date',
		'available_rooms',
		'price_override',
		'status',
		'block_reason',
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
		'room' => array(
			'key_from' => 'room_id',
			'model_to' => 'Model_Room',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);
	
	// Constants
	const STATUS_AVAILABLE = 'available';
	const STATUS_BLOCKED = 'blocked';
	const STATUS_MAINTENANCE = 'maintenance';
	const STATUS_SOLD_OUT = 'sold_out';
	
	/**
	 * Get availability for room on specific date
	 */
	public static function get_for_room_date($room_id, $date)
	{
		return self::query()
			->where('room_id', $room_id)
			->where('date', $date)
			->get_one();
	}
	
	/**
	 * Get availability for room in date range
	 */
	public static function get_for_room_range($room_id, $start_date, $end_date)
	{
		return self::query()
			->where('room_id', $room_id)
			->where('date', '>=', $start_date)
			->where('date', '<=', $end_date)
			->order_by('date', 'ASC')
			->get();
	}
	
	/**
	 * Check if room is available on date
	 */
	public static function is_available($room_id, $date, $quantity = 1)
	{
		$availability = self::get_for_room_date($room_id, $date);
		
		if (!$availability) {
			return true; // Default available if no record
		}
		
		return $availability->status == self::STATUS_AVAILABLE && 
			   $availability->available_rooms >= $quantity;
	}
	
	/**
	 * Block rooms for date
	 */
	public static function block_rooms($room_id, $date, $quantity, $reason = null)
	{
		$availability = self::get_for_room_date($room_id, $date);
		
		if (!$availability) {
			$availability = self::forge();
			$availability->room_id = $room_id;
			$availability->date = $date;
			$availability->available_rooms = 0;
		}
		
		$availability->available_rooms = max(0, $availability->available_rooms - $quantity);
		$availability->status = $availability->available_rooms > 0 ? self::STATUS_AVAILABLE : self::STATUS_SOLD_OUT;
		$availability->block_reason = $reason;
		$availability->save();
		
		return $availability;
	}
	
	/**
	 * Get effective price (override or room default)
	 */
	public function get_effective_price()
	{
		if ($this->price_override !== null) {
			return $this->price_override;
		}
		
		return $this->room->price;
	}
	
	/**
	 * Get status badge class
	 */
	public function get_status_badge_class()
	{
		$classes = array(
			self::STATUS_AVAILABLE => 'badge-success',
			self::STATUS_BLOCKED => 'badge-warning',
			self::STATUS_MAINTENANCE => 'badge-danger',
			self::STATUS_SOLD_OUT => 'badge-secondary',
		);
		
		return isset($classes[$this->status]) ? $classes[$this->status] : 'badge-secondary';
	}
}
