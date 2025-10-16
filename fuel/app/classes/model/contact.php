<?php

class Model_Contact extends \Orm\Model
{
	protected static $_table_name = 'contacts';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'name',
		'email',
		'phone',
		'subject',
		'message',
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
	const STATUS_NEW = 'new';
	const STATUS_READ = 'read';
	const STATUS_REPLIED = 'replied';
	const STATUS_CLOSED = 'closed';
	
	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			self::STATUS_NEW => 'Mới',
			self::STATUS_READ => 'Đã đọc',
			self::STATUS_REPLIED => 'Đã trả lời',
			self::STATUS_CLOSED => 'Đã đóng',
		);
	}
	
	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			self::STATUS_NEW => 'badge-light-danger',
			self::STATUS_READ => 'badge-light-info',
			self::STATUS_REPLIED => 'badge-light-success',
			self::STATUS_CLOSED => 'badge-light-secondary',
		);
		
		return isset($classes[$status]) ? $classes[$status] : 'badge-light-secondary';
	}
	
	/**
	 * Get contacts by status
	 */
	public static function get_by_status($status)
	{
		return self::query()
			->where('status', $status)
			->order_by('created_at', 'DESC')
			->get();
	}
	
	/**
	 * Get recent contacts
	 */
	public static function get_recent($limit = 10)
	{
		return self::query()
			->order_by('created_at', 'DESC')
			->limit($limit)
			->get();
	}
	
	/**
	 * Get unread count
	 */
	public static function get_unread_count()
	{
		return self::query()
			->where('status', self::STATUS_NEW)
			->count();
	}
}
