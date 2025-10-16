<?php

namespace Fuel\Migrations;

class Create_room_availability
{
	public function up()
	{
		\DBUtil::create_table('room_availability', array(
			'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'room_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'date' => array('type' => 'date', 'null' => false),
			'available_rooms' => array('type' => 'int', 'constraint' => 11, 'default' => 1),
			'price_override' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => true),
			'status' => array('type' => 'enum', 'constraint' => "'available','blocked','maintenance','sold_out'", 'default' => 'available'),
			'block_reason' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		// Add unique constraint
		\DB::query('ALTER TABLE room_availability ADD UNIQUE KEY uk_room_date (room_id, date)')->execute();
		
		// Add indexes for performance
		\DB::query('CREATE INDEX idx_room_availability_date ON room_availability(date)')->execute();
		\DB::query('CREATE INDEX idx_room_availability_status ON room_availability(status)')->execute();
	}
	
	public function down()
	{
		\DBUtil::drop_table('room_availability');
	}
}
