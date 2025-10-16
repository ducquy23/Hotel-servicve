<?php

class Model_Discount extends \Orm\Model
{
    protected static $_table_name = 'discounts';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
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
        'bookings' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Booking',
            'key_to' => 'discount_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
    
    // Constants
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED_AMOUNT = 'fixed_amount';
    
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_EXPIRED = 'expired';
    
    /**
     * Get active discounts
     */
    public static function get_active()
    {
        $now = date('Y-m-d H:i:s');
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->where('valid_from', '<=', $now)
            ->where('valid_until', '>=', $now)
            ->order_by('created_at', 'DESC')
            ->get();
    }
    
    /**
     * Get discount by code
     */
    public static function get_by_code($code)
    {
        return self::query()
            ->where('code', $code)
            ->get_one();
    }
    
    /**
     * Check if discount is valid
     */
    public function is_valid()
    {
        $now = date('Y-m-d H:i:s');
        
        // Check status
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }
        
        // Check date range
        if ($this->valid_from > $now || $this->valid_until < $now) {
            return false;
        }
        
        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Calculate discount amount
     */
    public function calculate_discount($amount)
    {
        if (!$this->is_valid()) {
            return 0;
        }
        
        $discount_amount = 0;
        
        if ($this->type === self::TYPE_PERCENTAGE) {
            $discount_amount = ($amount * $this->value) / 100;
        } else {
            $discount_amount = $this->value;
        }
        
        // Apply max discount limit
        if ($this->max_discount && $discount_amount > $this->max_discount) {
            $discount_amount = $this->max_discount;
        }
        
        // Don't exceed the amount
        if ($discount_amount > $amount) {
            $discount_amount = $amount;
        }
        
        return $discount_amount;
    }
    
    /**
     * Increment usage count
     */
    public function increment_usage()
    {
        $this->used_count++;
        $this->save();
    }
    
    /**
     * Get type options
     */
    public static function get_type_options()
    {
        return array(
            self::TYPE_PERCENTAGE => 'Phần trăm (%)',
            self::TYPE_FIXED_AMOUNT => 'Số tiền cố định',
        );
    }
}
