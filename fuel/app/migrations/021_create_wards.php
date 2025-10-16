<?php

namespace Fuel\Migrations;

class Create_wards
{
	public function up()
	{
		\DBUtil::create_table('wards', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'name' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'province_id' => array('null' => false, 'type' => 'bigint'),
			'iorder' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'type' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'code' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'created_at' => array('null' => false, 'type' => 'timestamp'),
			'updated_at' => array('null' => false, 'type' => 'timestamp'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('wards');
	}
}