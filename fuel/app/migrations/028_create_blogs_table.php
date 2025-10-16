<?php

namespace Fuel\Migrations;

class Create_blogs_table
{
	public function up()
	{
		\DBUtil::create_table('blogs', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'title' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'content' => array('null' => false, 'type' => 'text'),
			'excerpt' => array('constraint' => 500, 'null' => true, 'type' => 'varchar'),
			'featured_image' => array('constraint' => 255, 'null' => true, 'type' => 'varchar'),
			'category' => array('constraint' => 100, 'null' => false, 'type' => 'varchar'),
			'status' => array('constraint' => '"draft","published","archived"', 'null' => false, 'type' => 'enum', 'default' => 'draft'),
			'published_at' => array('null' => true, 'type' => 'datetime'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('blogs');
	}
}