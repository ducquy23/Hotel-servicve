<?php

namespace Fuel\Migrations;

class Create_services_table
{
	public function up()
	{
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
	}

	public function down()
	{
		\DBUtil::drop_table('services');
	}
}