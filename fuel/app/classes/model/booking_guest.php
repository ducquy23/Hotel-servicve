<?php

class Model_Booking_Guest extends \Orm\Model
{
    protected static $_table_name = 'booking_guests';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'booking_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'id_number',
        'id_type',
        'is_main_guest',
        'created_at',
        'updated_at',
    );
    
    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    
    // Relationships
    protected static $_belongs_to = array(
        'booking' => array(
            'key_from' => 'booking_id',
            'model_to' => 'Model_Booking',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    
    // Constants
    const ID_TYPE_PASSPORT = 'passport';
    const ID_TYPE_ID_CARD = 'id_card';
    const ID_TYPE_DRIVER_LICENSE = 'driver_license';
    
    /**
     * Get full name
     */
    public function get_full_name()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    
    /**
     * Get guests for booking
     */
    public static function get_for_booking($booking_id)
    {
        return self::query()
            ->where('booking_id', $booking_id)
            ->order_by('is_main_guest', 'DESC')
            ->order_by('first_name', 'ASC')
            ->get();
    }
    
    /**
     * Get main guest for booking
     */
    public static function get_main_guest($booking_id)
    {
        return self::query()
            ->where('booking_id', $booking_id)
            ->where('is_main_guest', 1)
            ->get_one();
    }
    
    /**
     * Get ID type options
     */
    public static function get_id_type_options()
    {
        return array(
            self::ID_TYPE_PASSPORT => 'Hộ chiếu',
            self::ID_TYPE_ID_CARD => 'CMND/CCCD',
            self::ID_TYPE_DRIVER_LICENSE => 'Bằng lái xe',
        );
    }
}
