<?php

class Model_Hotel_Amenity extends \Orm\Model
{
	protected static $_table_name = 'hotel_amenities';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'hotel_id',
		'amenity_id',
		'is_available',
		'custom_price',
		'custom_description',
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
		'hotel' => array(
			'key_from' => 'hotel_id',
			'model_to' => 'Model_Hotel',
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
	
	/**
	 * Get hotel amenities by hotel ID
	 */
	public static function get_by_hotel($hotel_id)
	{
		return self::query()
			->where('hotel_id', $hotel_id)
			->where('is_available', true)
			->order_by('amenity_id', 'ASC')
			->get();
	}
	
	/**
	 * Get available amenities for hotel
	 */
	public static function get_available_for_hotel($hotel_id)
	{
		return self::query()
			->where('hotel_id', $hotel_id)
			->where('is_available', true)
			->related('amenity')
			->get();
	}
	
	/**
	 * Get effective price (custom or amenity default)
	 */
	public function get_effective_price()
	{
		if ($this->custom_price !== null) {
			return $this->custom_price;
		}
		
		return $this->amenity->price;
	}
	
	/**
	 * Get effective description (custom or amenity default)
	 */
	public function get_effective_description()
	{
		if (!empty($this->custom_description)) {
			return $this->custom_description;
		}
		
		return $this->amenity->description;
	}
}
