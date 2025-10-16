<?php

namespace Fuel\Migrations;

class Merge_services_to_amenities
{
	public function up()
	{
		// Step 1: Add new fields to amenities table
		\DBUtil::add_fields('amenities', array(
			'price' => array('constraint' => '10,2', 'null' => true, 'type' => 'decimal'),
			'service_type' => array('constraint' => '"free","paid","optional"', 'null' => false, 'type' => 'enum', 'default' => 'free'),
			'is_24h' => array('constraint' => 1, 'null' => false, 'type' => 'tinyint', 'default' => 0),
			'operating_hours' => array('constraint' => 100, 'null' => true, 'type' => 'varchar'),
		));
		
		// Step 2: Migrate services data to amenities
		$services_sql = 'INSERT INTO amenities (name, description, icon, price, category, service_type, status, created_at, updated_at)
			SELECT 
				name, 
				description, 
				icon, 
				price,
				"service" as category,
				CASE 
					WHEN price IS NULL OR price = 0 THEN "free"
					ELSE "paid"
				END as service_type,
				status,
				created_at,
				updated_at
			FROM services';
		
		\DB::query($services_sql)->execute();
		
		// Step 3: Update existing amenities to have proper service_type
		\DB::query('UPDATE amenities SET service_type = "free" WHERE service_type IS NULL')->execute();
		
		// Step 4: Drop services table
		\DBUtil::drop_table('services');
		
		// Step 5: Create hotel_amenities table for many-to-many relationship
		\DBUtil::create_table('hotel_amenities', array(
			'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'hotel_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'amenity_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'is_available' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 1),
			'custom_price' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => true),
			'custom_description' => array('type' => 'text', 'null' => true),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		// Add unique constraint
		\DB::query('ALTER TABLE hotel_amenities ADD UNIQUE KEY uk_hotel_amenity (hotel_id, amenity_id)')->execute();
		
		// Step 6: Create booking_amenities table for additional services
		\DBUtil::create_table('booking_amenities', array(
			'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'booking_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'amenity_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'quantity' => array('type' => 'int', 'constraint' => 11, 'default' => 1),
			'unit_price' => array('type' => 'decimal', 'constraint' => '10,2'),
			'total_price' => array('type' => 'decimal', 'constraint' => '10,2'),
			'scheduled_date' => array('type' => 'date', 'null' => true),
			'scheduled_time' => array('type' => 'time', 'null' => true),
			'status' => array('type' => 'enum', 'constraint' => "'pending','confirmed','completed','cancelled'", 'default' => 'pending'),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		// Recreate services table
		\DBUtil::create_table('services', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'name' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'description' => array('null' => true, 'type' => 'text'),
			'icon' => array('constraint' => 100, 'null' => true, 'type' => 'varchar'),
			'price' => array('constraint' => '10,2', 'null' => true, 'type' => 'decimal'),
			'status' => array('constraint' => '"active","inactive"', 'null' => false, 'type' => 'enum', 'default' => 'active'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
		
		// Migrate back services data
		$services_sql = 'INSERT INTO services (name, description, icon, price, status, created_at, updated_at)
			SELECT name, description, icon, price, status, created_at, updated_at
			FROM amenities 
			WHERE category = "service"';
		
		\DB::query($services_sql)->execute();
		
		// Drop new tables
		\DBUtil::drop_table('booking_amenities');
		\DBUtil::drop_table('hotel_amenities');
		
		// Remove added fields from amenities
		\DBUtil::drop_fields('amenities', array(
			'price',
			'service_type',
			'is_24h',
			'operating_hours'
		));
	}
}
