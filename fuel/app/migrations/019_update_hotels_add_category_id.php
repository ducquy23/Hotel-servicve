<?php

namespace Fuel\Migrations;

class Update_hotels_add_category_id
{
    public function up(): void
    {
        \DBUtil::add_fields('hotels', array(
            'category_id' => array('type' => 'int', 'constraint' => 11, 'null' => true, 'after' => 'country'),
            'star_rating' => array('type' => 'int', 'constraint' => 1, 'default' => 3, 'after' => 'rating'),
            'website' => array('type' => 'varchar', 'constraint' => 255, 'null' => true, 'after' => 'phone'),
            'latitude' => array('type' => 'decimal', 'constraint' => '10,8', 'null' => true, 'after' => 'website'),
            'longitude' => array('type' => 'decimal', 'constraint' => '11,8', 'null' => true, 'after' => 'latitude'),
        ));
        
        // Add foreign key constraint
        // \DB::query('ALTER TABLE hotels ADD CONSTRAINT fk_hotels_category_id FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_fields('hotels', array('category_id', 'star_rating', 'website', 'latitude', 'longitude'));
    }
}
