<?php

namespace Fuel\Migrations;

class Create_hotels_table
{
    public function up(): void
    {
        \DBUtil::create_table('hotels', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 255),
            'description' => array('type' => 'text', 'null' => true),
            'address' => array('type' => 'varchar', 'constraint' => 255),
            'country' => array('type' => 'varchar', 'constraint' => 100),
            'phone' => array('type' => 'varchar', 'constraint' => 20),
            'email' => array('type' => 'varchar', 'constraint' => 100),
            'rating' => array('type' => 'decimal', 'constraint' => '3,2', 'default' => 0.00),
            'status' => array('type' => 'enum', 'constraint' => "'active','inactive'", 'default' => 'active'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'));
    }

    public function down(): void
    {
        \DBUtil::drop_table('hotels');
    }
}
