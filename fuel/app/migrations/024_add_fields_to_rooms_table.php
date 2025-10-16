<?php

namespace Fuel\Migrations;

class Add_fields_to_rooms_table
{
	public function up()
	{
		\DBUtil::add_fields('rooms', array(
			'size' => array('constraint' => 50, 'null' => true, 'type' => 'varchar'),
			'bed_type' => array('constraint' => 100, 'null' => true, 'type' => 'varchar'),
			'view_type' => array('constraint' => 50, 'null' => true, 'type' => 'varchar'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('rooms', array(
			'size',
			'bed_type',
			'view_type',
		));
	}
}