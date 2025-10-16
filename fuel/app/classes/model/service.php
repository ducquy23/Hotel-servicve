<?php

class Model_Service extends \Orm\Model
{
	protected static $_table_name = 'services';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'name',
		'description',
		'icon',
		'price',
		'status',
		'created_at',
		'updated_at',
	);
	
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => true,
		),
	);
	
	// Constants
	const STATUS_ACTIVE = 'active';
	const STATUS_INACTIVE = 'inactive';
	
	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			self::STATUS_ACTIVE => 'Hoạt động',
			self::STATUS_INACTIVE => 'Tạm dừng',
		);
	}
	
	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			self::STATUS_ACTIVE => 'badge-light-success',
			self::STATUS_INACTIVE => 'badge-light-secondary',
		);
		
		return isset($classes[$status]) ? $classes[$status] : 'badge-light-secondary';
	}
	
	/**
	 * Get icon options
	 */
	public static function get_icon_options()
	{
		return array(
			'feather-wifi' => 'Wifi',
			'feather-truck' => 'Vận chuyển',
			'feather-clock' => '24/7',
			'feather-airplay' => 'Điều hòa',
			'feather-tv' => 'TV',
			'feather-coffee' => 'Cafe',
			'feather-droplet' => 'Hồ bơi',
			'feather-activity' => 'Gym',
			'feather-bell' => 'Dịch vụ phòng',
			'feather-plane' => 'Sân bay',
			'feather-utensils' => 'Nhà hàng',
			'feather-car' => 'Đỗ xe',
			'feather-shield' => 'Bảo mật',
			'feather-heart' => 'Spa',
			'feather-music' => 'Giải trí',
		);
	}
	
	/**
	 * Get services by status
	 */
	public static function get_by_status($status)
	{
		return self::query()
			->where('status', $status)
			->order_by('name', 'ASC')
			->get();
	}
	
	/**
	 * Get active services
	 */
	public static function get_active()
	{
		return self::query()
			->where('status', self::STATUS_ACTIVE)
			->order_by('name', 'ASC')
			->get();
	}
	
	/**
	 * Get recent services
	 */
	public static function get_recent($limit = 10)
	{
		return self::query()
			->order_by('created_at', 'DESC')
			->limit($limit)
			->get();
	}
	
	/**
	 * Get formatted price
	 */
	public function get_formatted_price()
	{
		if (!$this->price) {
			return 'Miễn phí';
		}
		
		return number_format($this->price, 0, ',', '.') . ' VNĐ';
	}
	
	/**
	 * Get icon HTML
	 */
	public function get_icon_html()
	{
		if (!$this->icon) {
			return '<i class="feather feather-service"></i>';
		}
		
		return '<i class="feather ' . $this->icon . '"></i>';
	}
}
