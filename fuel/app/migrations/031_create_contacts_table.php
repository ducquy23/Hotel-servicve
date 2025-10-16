<?php

namespace Fuel\Migrations;

class Create_contacts_table
{
	public function up()
	{
		\DBUtil::create_table('contacts', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'name' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'email' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'phone' => array('constraint' => 20, 'null' => true, 'type' => 'varchar'),
			'subject' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'message' => array('null' => false, 'type' => 'text'),
			'status' => array('constraint' => '"new","read","replied","closed"', 'null' => false, 'type' => 'enum', 'default' => 'new'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('contacts');
	}
}