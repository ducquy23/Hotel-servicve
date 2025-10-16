<?php

class Model_Hotel_Image extends \Orm\Model
{
    protected static $_table_name = 'hotel_images';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'hotel_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order',
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
        'hotel' => array(
            'key_from' => 'hotel_id',
            'model_to' => 'Model_Hotel',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    
    /**
     * Get primary image for hotel
     */
    public static function get_primary_for_hotel($hotel_id)
    {
        return self::query()
            ->where('hotel_id', $hotel_id)
            ->where('is_primary', 1)
            ->get_one();
    }
    
    /**
     * Get all images for hotel ordered by sort_order
     */
    public static function get_for_hotel($hotel_id)
    {
        return self::query()
            ->where('hotel_id', $hotel_id)
            ->order_by('sort_order', 'ASC')
            ->order_by('created_at', 'ASC')
            ->get();
    }
    
    /**
     * Set as primary image (unset others)
     */
    public function set_as_primary()
    {
        // Unset other primary images for this hotel
        self::query()
            ->where('hotel_id', $this->hotel_id)
            ->where('is_primary', 1)
            ->update(array('is_primary' => 0));
        
        // Set this as primary
        $this->is_primary = 1;
        $this->save();
    }
    
    /**
     * Get full image URL
     */
    public function get_image_url()
    {
        return \Uri::base() . $this->image_path;
    }
}
