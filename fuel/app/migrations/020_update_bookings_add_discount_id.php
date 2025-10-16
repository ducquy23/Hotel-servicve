<?php

namespace Fuel\Migrations;

class Update_bookings_add_discount_id
{
    public function up(): void
    {
        \DBUtil::add_fields('bookings', array(
            'discount_id' => array('type' => 'int', 'constraint' => 11, 'null' => true, 'after' => 'total_price'),
            'discount_amount' => array('type' => 'decimal', 'constraint' => '10,2', 'default' => 0, 'after' => 'discount_id'),
            'final_price' => array('type' => 'decimal', 'constraint' => '10,2', 'after' => 'discount_amount'),
            'special_requests' => array('type' => 'text', 'null' => true, 'after' => 'final_price'),
        ));
        
        // Add foreign key constraint
        // \DB::query('ALTER TABLE bookings ADD CONSTRAINT fk_bookings_discount_id FOREIGN KEY (discount_id) REFERENCES discounts(id) ON DELETE SET NULL')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_fields('bookings', array('discount_id', 'discount_amount', 'final_price', 'special_requests'));
    }
}
