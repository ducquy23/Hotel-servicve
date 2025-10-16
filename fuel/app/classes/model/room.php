<?php
class Model_Room extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"hotel_id" => array(
			"label" => "Hotel id",
			"data_type" => "int",
		),
		"name" => array(
			"label" => "Name",
			"data_type" => "varchar",
		),
		"description" => array(
			"label" => "Description",
			"data_type" => "text",
		),
        "price" => array(
            "label" => "Price per night",
            "data_type" => "decimal",
        ),
		"capacity" => array(
			"label" => "Capacity",
			"data_type" => "int",
		),
		"size" => array(
			"label" => "Size",
			"data_type" => "varchar",
		),
		"bed_type" => array(
			"label" => "Bed type",
			"data_type" => "varchar",
		),
		"room_type" => array(
			"label" => "Room type",
			"data_type" => "enum",
		),
		"view_type" => array(
			"label" => "View type",
			"data_type" => "varchar",
		),
		"status" => array(
			"label" => "Status",
			"data_type" => "enum",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "datetime",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "datetime",
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'rooms';

	protected static $_primary_key = array('id');

	protected static $_has_many = array(
		'images' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Room_Image',
			'key_to' => 'room_id',
			'cascade_save' => true,
			'cascade_delete' => true,
		),
	);

	protected static $_many_many = array(
	);

	protected static $_has_one = array(
	);

	protected static $_belongs_to = array(
		'hotel' => array(
			'key_from' => 'hotel_id',
			'model_to' => 'Model_Hotel',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get room type options
	 */
	public static function get_room_type_options()
	{
		return array(
			'single' => 'Phòng đơn',
			'double' => 'Phòng đôi',
			'family' => 'Phòng gia đình',
			'suite' => 'Suite',
		);
	}

	/**
	 * Get status options
	 */
	public static function get_status_options()
	{
		return array(
			'active' => 'Hoạt động',
			'inactive' => 'Tạm dừng',
			'maintenance' => 'Bảo trì',
		);
	}

	/**
	 * Get status badge class
	 */
	public static function get_status_badge_class($status)
	{
		$classes = array(
			'active' => 'badge-light-success',
			'inactive' => 'badge-light-secondary',
			'maintenance' => 'badge-light-warning',
		);
		return $classes[$status] ?? 'badge-light-secondary';
	}

	/**
	 * Get bed type options
	 */
	public static function get_bed_type_options()
	{
		return array(
			'king' => 'King Bed',
			'queen' => 'Queen Bed',
			'twin' => 'Twin Beds',
			'single' => 'Single Bed',
			'double' => 'Double Bed',
		);
	}

	/**
	 * Get view type options
	 */
	public static function get_view_type_options()
	{
		return array(
			'sea' => 'Sea View',
			'city' => 'City View',
			'mountain' => 'Mountain View',
			'garden' => 'Garden View',
			'pool' => 'Pool View',
			'street' => 'Street View',
		);
	}

	/**
	 * Get formatted price
	 */
	public function get_formatted_price()
	{
		return number_format($this->price, 0, ',', '.') . ' VNĐ';
	}

	/**
	 * Get primary image
	 */
	public function get_primary_image()
	{
		return Model_Room_Image::get_primary_for_room($this->id);
	}

	/**
	 * Get all images
	 */
	public function get_all_images()
	{
		return Model_Room_Image::get_for_room($this->id);
	}

}
