<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'name' => array('constraint' => 100, 'null' => false, 'type' => 'varchar'),
			'full_name' => array('constraint' => 100, 'null' => false, 'type' => 'varchar'),
			'email' => array('constraint' => 150, 'null' => false, 'type' => 'varchar', 'unique' => true),
			'password' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'phone' => array('constraint' => 20, 'null' => false, 'type' => 'varchar'),
			'role' => array('null' => false, 'constraint' => '"customer","partner"', 'type' => 'enum'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}