<?php

class Model_Blog extends \Orm\Model
{
	protected static $_table_name = 'blogs';
	
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'title',
		'content',
		'excerpt',
		'featured_image',
		'category',
		'status',
		'published_at',
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
	const STATUS_DRAFT = 'draft';
	const STATUS_PUBLISHED = 'published';
	const STATUS_ARCHIVED = 'archived';
	
	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			self::STATUS_DRAFT => 'Bản nháp',
			self::STATUS_PUBLISHED => 'Đã xuất bản',
			self::STATUS_ARCHIVED => 'Lưu trữ',
		);
	}
	
	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			self::STATUS_DRAFT => 'badge-light-warning',
			self::STATUS_PUBLISHED => 'badge-light-success',
			self::STATUS_ARCHIVED => 'badge-light-secondary',
		);
		
		return isset($classes[$status]) ? $classes[$status] : 'badge-light-secondary';
	}
	
	/**
	 * Get category options
	 */
	public static function get_category_options()
	{
		return array(
			'travel' => 'Du lịch',
			'hotel' => 'Khách sạn',
			'food' => 'Ẩm thực',
			'event' => 'Sự kiện',
			'news' => 'Tin tức',
			'promotion' => 'Khuyến mãi',
		);
	}
	
	/**
	 * Get blogs by status
	 */
	public static function get_by_status($status)
	{
		return self::query()
			->where('status', $status)
			->order_by('created_at', 'DESC')
			->get();
	}
	
	/**
	 * Get published blogs
	 */
	public static function get_published()
	{
		return self::query()
			->where('status', self::STATUS_PUBLISHED)
			->order_by('published_at', 'DESC')
			->get();
	}
	
	/**
	 * Get recent blogs
	 */
	public static function get_recent($limit = 10)
	{
		return self::query()
			->where('status', self::STATUS_PUBLISHED)
			->order_by('published_at', 'DESC')
			->limit($limit)
			->get();
	}
	
	/**
	 * Get blogs by category
	 */
	public static function get_by_category($category)
	{
		return self::query()
			->where('category', $category)
			->where('status', self::STATUS_PUBLISHED)
			->order_by('published_at', 'DESC')
			->get();
	}
	
	/**
	 * Get excerpt from content
	 */
	public function get_excerpt($length = 150)
	{
		if ($this->excerpt) {
			return $this->excerpt;
		}
		
		$content = strip_tags($this->content);
		if (strlen($content) <= $length) {
			return $content;
		}
		
		return substr($content, 0, $length) . '...';
	}
	
	/**
	 * Get formatted published date
	 */
	public function get_published_date($format = 'd/m/Y')
	{
		if (!$this->published_at) {
			return null;
		}
		
		return date($format, strtotime($this->published_at));
	}
}
