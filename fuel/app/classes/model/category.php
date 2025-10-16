<?php

class Model_Category extends \Orm\Model
{
    protected static $_table_name = 'categories';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'name',
        'description',
        'icon',
        'status',
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
    protected static $_has_many = array(
        'hotels' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Hotel',
            'key_to' => 'category_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    // Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    /**
     * Get all active categories
     */
    public static function get_active()
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->order_by('name', 'ASC')
            ->get();
    }
    
    /**
     * Get category by name
     */
    public static function get_by_name($name)
    {
        return self::query()
            ->where('name', $name)
            ->get_one();
    }
}
