<?php

namespace Fuel\Migrations;

class Create_booking_rooms
{
	public function up()
	{
		\DBUtil::create_table('booking_rooms', array(
			'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'booking_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'room_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'quantity' => array('type' => 'int', 'constraint' => 11, 'default' => 1),
			'price_per_night' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => false),
			'total_nights' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'total_price' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => false),
			'guest_requests' => array('type' => 'text', 'null' => true),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		// Add indexes
		\DB::query('CREATE INDEX idx_booking_rooms_booking ON booking_rooms(booking_id)')->execute();
		\DB::query('CREATE INDEX idx_booking_rooms_room ON booking_rooms(room_id)')->execute();
	}
	
	public function down()
	{
		\DBUtil::drop_table('booking_rooms');
	}
}
