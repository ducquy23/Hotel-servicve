<?php

class Model_Ward extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"name" => array(
			"label" => "Name",
			"data_type" => "varchar",
		),
		"province_id" => array(
			"label" => "Province id",
			"data_type" => "bigint",
		),
		"iorder" => array(
			"label" => "Iorder",
			"data_type" => "int",
		),
		"type" => array(
			"label" => "Type",
			"data_type" => "varchar",
		),
		"code" => array(
			"label" => "Code",
			"data_type" => "varchar",
		),
		"created_at" => array(
			"label" => "Created at",
			"data_type" => "timestamp",
		),
		"updated_at" => array(
			"label" => "Updated at",
			"data_type" => "timestamp",
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

	protected static $_table_name = 'wards';

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
