<?php

class Model_Room_Image extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"room_id" => array(
			"label" => "Room id",
			"data_type" => "int",
		),
		"image_url" => array(
			"label" => "Image url",
			"data_type" => "varchar",
		),
		"is_primary" => array(
			"label" => "Is primary",
			"data_type" => "boolean",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "int",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "int",
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

	protected static $_table_name = 'room_images';

	protected static $_primary_key = array('id');

	protected static $_has_many = array(
	);

	protected static $_many_many = array(
	);

	protected static $_has_one = array(
	);

	protected static $_belongs_to = array(
	);

}
