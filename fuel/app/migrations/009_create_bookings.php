<?php

namespace Fuel\Migrations;

class Create_bookings
{
	public function up()
	{
		\DBUtil::create_table('bookings', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'user_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'room_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'hotel_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'check_in' => array('null' => false, 'type' => 'date'),
			'check_out' => array('null' => false, 'type' => 'date'),
			'total_price' => array('constraint' => '10,2', 'null' => false, 'type' => 'decimal'),
			'status' => array('null' => false, 'constraint' => '"pending","confirmed","cancelled","completed"', 'type' => 'enum'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('bookings');
	}
}