<?php

namespace Fuel\Migrations;

class Add_sample_booking
{
	public function up()
	{
		// Add sample booking with booking_rooms
		$booking_data = array(
			'user_id' => 1,
			'hotel_id' => 1,
			'room_id' => 1, // Required field
			'booking_reference' => 'BK' . date('Ymd') . '001',
			'check_in' => date('Y-m-d'),
			'check_out' => date('Y-m-d', strtotime('+2 days')),
			'guest_count' => 2,
			'total_price' => 2400000, // Changed from total_amount to total_price
			'final_price' => 2400000, // Add final_price field
			'status' => 'confirmed',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		\DB::query('INSERT INTO bookings (user_id, hotel_id, room_id, booking_reference, check_in, check_out, guest_count, total_price, final_price, status, created_at, updated_at) 
			VALUES (:user_id, :hotel_id, :room_id, :booking_reference, :check_in, :check_out, :guest_count, :total_price, :final_price, :status, :created_at, :updated_at)')
			->parameters($booking_data)
			->execute();

		$booking_id = \DB::query('SELECT LAST_INSERT_ID() as id')->execute()->as_array()[0]['id'];

		// Add booking rooms
		$booking_rooms_data = array(
			array(
				'booking_id' => $booking_id,
				'room_id' => 1,
				'quantity' => 1,
				'price_per_night' => 800000,
				'total_nights' => 2,
				'total_price' => 1600000,
				'guest_requests' => 'Phòng tầng cao, view biển'
			),
			array(
				'booking_id' => $booking_id,
				'room_id' => 2,
				'quantity' => 1,
				'price_per_night' => 400000,
				'total_nights' => 2,
				'total_price' => 800000,
				'guest_requests' => 'Phòng gần thang máy'
			)
		);

		foreach ($booking_rooms_data as $room) {
			\DB::query('INSERT INTO booking_rooms (booking_id, room_id, quantity, price_per_night, total_nights, total_price, guest_requests, created_at, updated_at) 
				VALUES (:booking_id, :room_id, :quantity, :price_per_night, :total_nights, :total_price, :guest_requests, NOW(), NOW())')
				->parameters($room)
				->execute();
		}

		// Add booking amenities
		$booking_amenities_data = array(
			array(
				'booking_id' => $booking_id,
				'amenity_id' => 3, // Spa & Massage
				'quantity' => 2,
				'unit_price' => 500000,
				'total_price' => 1000000,
				'scheduled_date' => date('Y-m-d', strtotime('+1 day')),
				'scheduled_time' => '15:00:00',
				'status' => 'confirmed'
			),
			array(
				'booking_id' => $booking_id,
				'amenity_id' => 5, // Dịch vụ phòng
				'quantity' => 1,
				'unit_price' => 100000,
				'total_price' => 100000,
				'scheduled_date' => date('Y-m-d'),
				'scheduled_time' => '20:00:00',
				'status' => 'pending'
			)
		);

		foreach ($booking_amenities_data as $amenity) {
			\DB::query('INSERT INTO booking_amenities (booking_id, amenity_id, quantity, unit_price, total_price, scheduled_date, scheduled_time, status, created_at, updated_at) 
				VALUES (:booking_id, :amenity_id, :quantity, :unit_price, :total_price, :scheduled_date, :scheduled_time, :status, NOW(), NOW())')
				->parameters($amenity)
				->execute();
		}
	}

	public function down()
	{
		\DB::query('DELETE FROM booking_amenities WHERE booking_id IN (SELECT id FROM bookings WHERE booking_reference LIKE "BK%")')->execute();
		\DB::query('DELETE FROM booking_rooms WHERE booking_id IN (SELECT id FROM bookings WHERE booking_reference LIKE "BK%")')->execute();
		\DB::query('DELETE FROM bookings WHERE booking_reference LIKE "BK%"')->execute();
	}
}
