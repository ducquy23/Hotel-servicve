<?php

namespace Fuel\Migrations;

class Enhance_rooms_table
{
	public function up()
	{
		\DBUtil::add_fields('rooms', array(
			'floor_number' => array('type' => 'int', 'constraint' => 11, 'null' => true),
			'room_number' => array('type' => 'varchar', 'constraint' => 10, 'null' => true),
			'max_occupancy' => array('type' => 'int', 'constraint' => 11, 'default' => 2),
			'adult_capacity' => array('type' => 'int', 'constraint' => 11, 'default' => 2),
			'child_capacity' => array('type' => 'int', 'constraint' => 11, 'default' => 1),
			'smoking_allowed' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'balcony' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'sea_view' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'city_view' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'garden_view' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'air_conditioning' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 1),
			'minibar' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'safe' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'wifi' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 1),
			'tv' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 1),
			'room_service' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'breakfast_included' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'is_featured' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
		));
		
		// Add indexes
		\DB::query('CREATE INDEX idx_rooms_featured ON rooms(is_featured)')->execute();
		\DB::query('CREATE INDEX idx_rooms_capacity ON rooms(adult_capacity, child_capacity)')->execute();
	}
	
	public function down()
	{
		\DBUtil::drop_fields('rooms', array(
			'floor_number',
			'room_number',
			'max_occupancy',
			'adult_capacity',
			'child_capacity',
			'smoking_allowed',
			'balcony',
			'sea_view',
			'city_view',
			'garden_view',
			'air_conditioning',
			'minibar',
			'safe',
			'wifi',
			'tv',
			'room_service',
			'breakfast_included',
			'is_featured',
		));
	}
}
