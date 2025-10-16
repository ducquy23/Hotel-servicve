<?php

namespace Fuel\Migrations;

class Create_rooms
{
	public function up()
	{
		\DBUtil::create_table('rooms', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'hotel_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'name' => array('constraint' => 100, 'null' => false, 'type' => 'varchar'),
			'description' => array('null' => false, 'type' => 'text'),
			'price' => array('constraint' => '10,2', 'null' => false, 'type' => 'decimal'),
			'capacity' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'room_type' => array('null' => false, 'constraint' => '"standard","deluxe","suite"', 'type' => 'enum'),
			'status' => array('null' => false, 'constraint' => '"active","inactive"', 'type' => 'enum'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('rooms');
	}
}