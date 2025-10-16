<?php

namespace Fuel\Migrations;

class Create_reviews
{
	public function up()
	{
		\DBUtil::create_table('reviews', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'user_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'hotel_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'rating' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'comment' => array('null' => false, 'type' => 'text'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('constraint' => '11', 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('reviews');
	}
}