<?php

namespace Fuel\Migrations;

class Create_amenities_table
{
    public function up(): void
    {
        \DBUtil::create_table('amenities', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 100),
            'description' => array('type' => 'text', 'null' => true),
            'icon' => array('type' => 'varchar', 'constraint' => 50, 'null' => true),
            'category' => array('type' => 'enum', 'constraint' => "'general','room','facility','service'", 'default' => 'general'),
            'status' => array('type' => 'enum', 'constraint' => "'active','inactive'", 'default' => 'active'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'));
    }

    public function down(): void
    {
        \DBUtil::drop_table('amenities');
    }
}
