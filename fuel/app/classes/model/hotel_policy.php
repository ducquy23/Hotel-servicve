<?php

class Model_Hotel_Policy extends \Orm\Model
{
	protected static $_table_name = 'hotel_policies';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'hotel_id',
		'policy_type',
		'title',
		'description',
		'is_mandatory',
		'display_order',
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
		'hotel' => array(
			'key_from' => 'hotel_id',
			'model_to' => 'Model_Hotel',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);
	
	// Constants
	const POLICY_TYPE_CHECKIN = 'checkin';
	const POLICY_TYPE_CHECKOUT = 'checkout';
	const POLICY_TYPE_CANCELLATION = 'cancellation';
	const POLICY_TYPE_PAYMENT = 'payment';
	const POLICY_TYPE_PETS = 'pets';
	const POLICY_TYPE_SMOKING = 'smoking';
	const POLICY_TYPE_CHILDREN = 'children';
	const POLICY_TYPE_OTHER = 'other';
	
	/**
	 * Get policies by hotel
	 */
	public static function get_by_hotel($hotel_id, $policy_type = null)
	{
		$query = self::query()
			->where('hotel_id', $hotel_id)
			->where('status', 'active')
			->order_by('display_order', 'ASC')
			->order_by('id', 'ASC');
		
		if ($policy_type) {
			$query->where('policy_type', $policy_type);
		}
		
		return $query->get();
	}
	
	/**
	 * Get mandatory policies
	 */
	public static function get_mandatory($hotel_id)
	{
		return self::query()
			->where('hotel_id', $hotel_id)
			->where('is_mandatory', true)
			->where('status', 'active')
			->order_by('display_order', 'ASC')
			->get();
	}
	
	/**
	 * Get policy type options
	 */
	public static function get_policy_type_options()
	{
		return array(
			self::POLICY_TYPE_CHECKIN => 'Giờ nhận phòng',
			self::POLICY_TYPE_CHECKOUT => 'Giờ trả phòng',
			self::POLICY_TYPE_CANCELLATION => 'Chính sách hủy',
			self::POLICY_TYPE_PAYMENT => 'Chính sách thanh toán',
			self::POLICY_TYPE_PETS => 'Chính sách thú cưng',
			self::POLICY_TYPE_SMOKING => 'Chính sách hút thuốc',
			self::POLICY_TYPE_CHILDREN => 'Chính sách trẻ em',
			self::POLICY_TYPE_OTHER => 'Khác',
		);
	}
	
	/**
	 * Get policy type badge class
	 */
	public function get_policy_type_badge_class()
	{
		$classes = array(
			self::POLICY_TYPE_CHECKIN => 'badge-info',
			self::POLICY_TYPE_CHECKOUT => 'badge-info',
			self::POLICY_TYPE_CANCELLATION => 'badge-warning',
			self::POLICY_TYPE_PAYMENT => 'badge-success',
			self::POLICY_TYPE_PETS => 'badge-secondary',
			self::POLICY_TYPE_SMOKING => 'badge-danger',
			self::POLICY_TYPE_CHILDREN => 'badge-primary',
			self::POLICY_TYPE_OTHER => 'badge-light',
		);
		
		return isset($classes[$this->policy_type]) ? $classes[$this->policy_type] : 'badge-light';
	}
}
