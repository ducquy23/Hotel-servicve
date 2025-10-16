<?php

class Model_Amenity extends \Orm\Model
{
    protected static $_table_name = 'amenities';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'name',
        'description',
        'icon',
        'category',
        'price',
        'service_type',
        'is_24h',
        'operating_hours',
        'status',
        'created_at',
        'updated_at',
    );
    
        protected static $_observers = array(
            'Orm\\Observer_CreatedAt' => array(
                'events' => array('before_insert'),
                'mysql_timestamp' => true,
                'property' => 'created_at',
            ),
            'Orm\\Observer_UpdatedAt' => array(
                'events' => array('before_insert', 'before_update'),
                'mysql_timestamp' => true,
                'property' => 'updated_at',
            ),
        );
    
    // Relationships
    protected static $_many_many = array(
        'hotels' => array(
            'key_from' => 'id',
            'key_through_from' => 'amenity_id',
            'table_through' => 'hotel_amenities',
            'key_through_to' => 'hotel_id',
            'model_to' => 'Model_Hotel',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    // Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const CATEGORY_GENERAL = 'general';
    const CATEGORY_ROOM = 'room';
    const CATEGORY_FACILITY = 'facility';
    const CATEGORY_SERVICE = 'service';
    
    const SERVICE_TYPE_FREE = 'free';
    const SERVICE_TYPE_PAID = 'paid';
    const SERVICE_TYPE_OPTIONAL = 'optional';
    
    /**
     * Get all active amenities
     */
    public static function get_active()
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get amenities by category
     */
    public static function get_by_category($category)
    {
        return self::query()
            ->where('category', $category)
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get amenity by name
     */
    public static function get_by_name($name)
    {
        return self::query()
            ->where('name', $name)
            ->get_one();
    }
    
    /**
     * Get amenities by service type
     */
    public static function get_by_service_type($service_type)
    {
        return self::query()
            ->where('service_type', $service_type)
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get free amenities
     */
    public static function get_free()
    {
        return self::get_by_service_type(self::SERVICE_TYPE_FREE);
    }
    
    /**
     * Get paid amenities
     */
    public static function get_paid()
    {
        return self::get_by_service_type(self::SERVICE_TYPE_PAID);
    }
    
    /**
     * Get formatted price
     */
    public function get_formatted_price()
    {
        if (!$this->price || $this->price == 0) {
            return 'Miễn phí';
        }
        
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }
    
    /**
     * Check if amenity is free
     */
    public function is_free()
    {
        return $this->service_type == self::SERVICE_TYPE_FREE || !$this->price || $this->price == 0;
    }
    
    /**
     * Get service type options
     */
    public static function get_service_type_options()
    {
        return array(
            self::SERVICE_TYPE_FREE => 'Miễn phí',
            self::SERVICE_TYPE_PAID => 'Có phí',
            self::SERVICE_TYPE_OPTIONAL => 'Tùy chọn',
        );
    }
}
