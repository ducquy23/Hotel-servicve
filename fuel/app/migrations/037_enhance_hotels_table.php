<?php

namespace Fuel\Migrations;

class Enhance_hotels_table
{
	public function up()
	{
		\DBUtil::add_fields('hotels', array(
			'checkin_time' => array('type' => 'time', 'default' => '14:00:00'),
			'checkout_time' => array('type' => 'time', 'default' => '12:00:00'),
			'cancellation_policy' => array('type' => 'text', 'null' => true),
			// 'star_rating' => array('type' => 'int', 'constraint' => 1, 'default' => 3),
			'wifi_password' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
			'manager_name' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
			'manager_phone' => array('type' => 'varchar', 'constraint' => 20, 'null' => true),
			// 'website' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'facebook' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'instagram' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			// 'latitude' => array('type' => 'decimal', 'constraint' => '10,8', 'null' => true),
			// 'longitude' => array('type' => 'decimal', 'constraint' => '11,8', 'null' => true),
			'is_featured' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'featured_until' => array('type' => 'datetime', 'null' => true),
		));
		
		// Add indexes
		\DB::query('CREATE INDEX idx_hotels_featured ON hotels(is_featured, featured_until)')->execute();
		\DB::query('CREATE INDEX idx_hotels_location ON hotels(latitude, longitude)')->execute();
	}
	
	public function down()
	{
		\DBUtil::drop_fields('hotels', array(
			'checkin_time',
			'checkout_time',
			'cancellation_policy',
			'star_rating',
			'wifi_password',
			'manager_name',
			'manager_phone',
			'website',
			'facebook',
			'instagram',
			'latitude',
			'longitude',
			'is_featured',
			'featured_until',
		));
	}
}
