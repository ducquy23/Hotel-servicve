<?php

namespace Fuel\Migrations;

class Create_booking_guests_table
{
    public function up(): void
    {
        \DBUtil::create_table('booking_guests', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'booking_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'first_name' => array('type' => 'varchar', 'constraint' => 100),
            'last_name' => array('type' => 'varchar', 'constraint' => 100),
            'email' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'phone' => array('type' => 'varchar', 'constraint' => 20, 'null' => true),
            'id_number' => array('type' => 'varchar', 'constraint' => 50, 'null' => true),
            'id_type' => array('type' => 'enum', 'constraint' => "'passport','id_card','driver_license'", 'null' => true),
            'is_main_guest' => array('type' => 'tinyint', 'constraint' => 1, 'default' => 0),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'));
        
        // Add foreign key constraint
//        \DB::query('ALTER TABLE booking_guests ADD CONSTRAINT fk_booking_guests_booking_id FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE')->execute();
    }

    public function down(): void
    {
        \DBUtil::drop_table('booking_guests');
    }
}
