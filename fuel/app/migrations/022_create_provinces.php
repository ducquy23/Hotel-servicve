<?php

namespace Fuel\Migrations;

class Create_provinces
{
	public function up()
	{
		\DBUtil::create_table('provinces', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'name' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'type' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'code' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'created_at' => array('null' => false, 'type' => 'timestamp'),
			'updated_at' => array('null' => false, 'type' => 'timestamp'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('provinces');
	}
}