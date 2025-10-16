<?php

namespace Fuel\Migrations;

use Fuel\Core\DBUtil;

class Add_fields_to_bookings_table
{
	public function up()
	{
		DBUtil::add_fields('bookings', array(
			'guest_count' => array('constraint' => 3, 'null' => false, 'type' => 'int', 'default' => 1),
			'booking_reference' => array('constraint' => 20, 'null' => false, 'type' => 'varchar', 'unique' => true),
			'cancellation_reason' => array('null' => true, 'type' => 'text'),
		));
	}

	public function down()
	{

		DBUtil::drop_fields('bookings', array(
			'guest_count',
			'booking_reference',
			'cancellation_reason',
		));
	}
}