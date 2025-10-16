<?php

class Model_Hotel extends \Orm\Model
{
    protected static $_table_name = 'hotels';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'name',
        'description',
        'address',
        'country',
        'phone',
        'email',
        'rating',
        'status',
        'category_id',
        'star_rating',
        'website',
        'latitude',
        'longitude',
        'province_id',
        'ward_id',
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
        'category' => array(
            'key_from' => 'category_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'province' => array(
            'key_from' => 'province_id',
            'model_to' => 'Model_Province',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'ward' => array(
            'key_from' => 'ward_id',
            'model_to' => 'Model_Ward',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    protected static $_has_many = array(
        'rooms' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Room',
            'key_to' => 'hotel_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'images' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Hotel_Image',
            'key_to' => 'hotel_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'reviews' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Review',
            'key_to' => 'hotel_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    protected static $_many_many = array(
        'amenities' => array(
            'key_from' => 'id',
            'key_through_from' => 'hotel_id',
            'table_through' => 'hotel_amenities',
            'key_through_to' => 'amenity_id',
            'model_to' => 'Model_Amenity',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    // Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    /**
     * Get active hotels
     */
    public static function get_active()
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get hotels by city
     */
    public static function get_by_city($city)
    {
        return self::query()
            ->where('city', $city)
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get primary image
     */
    public function get_primary_image()
    {
        return Model_Hotel_Image::get_primary_for_hotel($this->id);
    }
    
    /**
     * Get all images
     */
    public function get_images()
    {
        return Model_Hotel_Image::get_for_hotel($this->id);
    }
    
    /**
     * Get average rating
     */
    public function get_average_rating()
    {
        $reviews = $this->reviews;
        if (empty($reviews)) {
            return 0;
        }
        
        $total_rating = 0;
        foreach ($reviews as $review) {
            $total_rating += $review->rating;
        }
        
        return round($total_rating / count($reviews), 1);
    }
    
    /**
     * Get full address
     */
    public function get_full_address()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->country;
    }
}
