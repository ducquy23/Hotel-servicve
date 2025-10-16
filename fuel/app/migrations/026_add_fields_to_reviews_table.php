<?php

namespace Fuel\Migrations;

class Add_fields_to_reviews_table
{
	public function up()
	{
		\DBUtil::add_fields('reviews', array(
			'room_id' => array('constraint' => '11', 'null' => true, 'type' => 'int'),
			'booking_id' => array('constraint' => '11', 'null' => true, 'type' => 'int'),
			'is_anonymous' => array('constraint' => 1, 'null' => false, 'type' => 'tinyint', 'default' => 0),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('reviews', array(
			'room_id',
			'booking_id',
			'is_anonymous',
		));
	}
}