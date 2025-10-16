<?php

namespace Fuel\Migrations;

class Create_hotel_images_table
{
    public function up(): void
    {
        \DBUtil::create_table('hotel_images', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'hotel_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'image_path' => array('type' => 'varchar', 'constraint' => 255),
            'alt_text' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
            'is_primary' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
            'sort_order' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'));
        
        // Add foreign key constraint
//        \DB::query('ALTER TABLE hotel_images ADD CONSTRAINT fk_hotel_images_hotel_id FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_table('hotel_images');
    }
}
