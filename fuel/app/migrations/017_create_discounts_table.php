<?php

namespace Fuel\Migrations;

class Create_discounts_table
{
    public function up(): void
    {
        \DBUtil::create_table('discounts', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'code' => array('type' => 'varchar', 'constraint' => 50),
            'name' => array('type' => 'varchar', 'constraint' => 100),
            'description' => array('type' => 'text', 'null' => true),
            'type' => array('type' => 'enum', 'constraint' => "'percentage','fixed_amount'", 'default' => 'percentage'),
            'value' => array('type' => 'decimal', 'constraint' => '10,2'),
            'min_amount' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => true),
            'max_discount' => array('type' => 'decimal', 'constraint' => '10,2', 'null' => true),
            'usage_limit' => array('type' => 'int', 'constraint' => 11, 'null' => true),
            'used_count' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
            'valid_from' => array('type' => 'datetime'),
            'valid_until' => array('type' => 'datetime'),
            'status' => array('type' => 'enum', 'constraint' => "'active','inactive','expired'", 'default' => 'active'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'));
        
        // Add unique constraint for code
        \DB::query('ALTER TABLE discounts ADD UNIQUE KEY uk_discounts_code (code)')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_table('discounts');
    }
}
