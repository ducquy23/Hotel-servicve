<?php

namespace Fuel\Migrations;

class Add_ward_id_and_province_id_to_hotels
{
	public function up()
	{
		\DBUtil::add_fields('hotels', array(
			'ward_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'province_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('hotels', array(
			'ward_id'
,			'province_id'
		));
	}
}