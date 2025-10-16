<?php

namespace Fuel\Migrations;

class Create_hotel_policies
{
	public function up()
	{
		\DBUtil::create_table('hotel_policies', array(
			'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'hotel_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
			'policy_type' => array('type' => 'enum', 'constraint' => "'checkin','checkout','cancellation','payment','pets','smoking','children','other'", 'null' => false),
			'title' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
			'description' => array('type' => 'text', 'null' => true),
			'is_mandatory' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
			'display_order' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
			'status' => array('type' => 'enum', 'constraint' => "'active','inactive'", 'default' => 'active'),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		// Add indexes
		\DB::query('CREATE INDEX idx_hotel_policies_hotel ON hotel_policies(hotel_id)')->execute();
		\DB::query('CREATE INDEX idx_hotel_policies_type ON hotel_policies(policy_type)')->execute();
	}
	
	public function down()
	{
		\DBUtil::drop_table('hotel_policies');
	}
}
