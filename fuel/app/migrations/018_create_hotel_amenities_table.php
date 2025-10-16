<?php

namespace Fuel\Migrations;

class Create_hotel_amenities_table
{
    public function up(): void
    {
        \DBUtil::create_table('hotel_amenities', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'hotel_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'amenity_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'created_at' => array('type' => 'datetime'),
        ), array('id'));
        
        // Add foreign key constraints
        // \DB::query('ALTER TABLE hotel_amenities ADD CONSTRAINT fk_hotel_amenities_hotel_id FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE')->execute();
        // \DB::query('ALTER TABLE hotel_amenities ADD CONSTRAINT fk_hotel_amenities_amenity_id FOREIGN KEY (amenity_id) REFERENCES amenities(id) ON DELETE CASCADE')->execute();
        
        // Add unique constraint
        \DB::query('ALTER TABLE hotel_amenities ADD UNIQUE KEY uk_hotel_amenities (hotel_id, amenity_id)')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_table('hotel_amenities');
    }
}
