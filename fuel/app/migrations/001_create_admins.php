<?php

namespace Fuel\Migrations;

use Fuel\Core\DBUtil;

class Create_admins
{
	public function up()
	{
        DBUtil::create_table('admins', array(
            'id' => array('constraint' => 20, 'type' => 'bigint', 'auto_increment' => true, 'unsigned' => true),
            'username' => array('constraint' => 255, 'type' => 'varchar'),
            'status' => array('constraint' => "'active','inactive','suspended'", 'type' => 'enum', 'null' => true, 'default' => null),
            'admin_created_id' => array('type' => 'bigint', 'null' => true, 'unsigned' => true),
            'email' => array('constraint' => 255, 'type' => 'varchar'),
            'password' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('type' => 'timestamp', 'null' => true, 'default' => null),
            'updated_at' => array('type' => 'timestamp', 'null' => true, 'default' => null),
            'two_factor_secret' => array('type' => 'text', 'null' => true),
            'two_factor_recovery_codes' => array('type' => 'text', 'null' => true),
            'two_factor_confirmed_at' => array('type' => 'timestamp', 'null' => true, 'default' => null),
        ), array('id'));
	}

	public function down()
	{
		DBUtil::drop_table('admins');
	}
}