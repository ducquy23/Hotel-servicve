<?php

namespace Fuel\Migrations;

class Create_room_images
{
	public function up()
	{
		\DBUtil::create_table('room_images', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'room_id' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'image_url' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'is_primary' => array('null' => false, 'type' => 'boolean'),
			'created_at' => array('constraint' => '11', 'null' => true, 'type' => 'int', 'unsigned' => true),
			'updated_at' => array('constraint' => '11', 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('room_images');
	}
}