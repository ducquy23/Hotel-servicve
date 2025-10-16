<?php

namespace Fuel\Migrations;

class Create_testimonials_table
{
	public function up()
	{
		\DBUtil::create_table('testimonials', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'user_id' => array('constraint' => '11', 'null' => true, 'type' => 'int'),
			'hotel_id' => array('constraint' => '11', 'null' => true, 'type' => 'int'),
			'rating' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'comment' => array('null' => false, 'type' => 'text'),
			'avatar' => array('constraint' => 255, 'null' => true, 'type' => 'varchar'),
			'is_featured' => array('constraint' => 1, 'null' => false, 'type' => 'tinyint', 'default' => 0),
			'status' => array('constraint' => '"active","inactive"', 'null' => false, 'type' => 'enum', 'default' => 'active'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('testimonials');
	}
}