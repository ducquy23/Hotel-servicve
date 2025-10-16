<?php

namespace Fuel\Migrations;

class Add_fields_to_users_table
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'avatar' => array('constraint' => 255, 'null' => true, 'type' => 'varchar'),
			'date_of_birth' => array('null' => true, 'type' => 'date'),
			'gender' => array('constraint' => '"male","female","other"', 'null' => true, 'type' => 'enum'),
			'address' => array('null' => true, 'type' => 'text'),
			'is_verified' => array('constraint' => 1, 'null' => false, 'type' => 'tinyint', 'default' => 0),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'avatar',
			'date_of_birth',
			'gender',
			'address',
			'is_verified',
		));
	}
}