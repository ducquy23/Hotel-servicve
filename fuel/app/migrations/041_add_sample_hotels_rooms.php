<?php

namespace Fuel\Migrations;

class Add_sample_hotels_rooms
{
	public function up()
	{
		// Add sample hotels with new fields
		$hotels_data = array(
			array(
				'name' => 'Khách sạn Paradise Resort',
				'description' => 'Khách sạn 5 sao với view biển tuyệt đẹp',
				'address' => '123 Đường Biển, Phường 1',
				'country' => 'Việt Nam',
				'phone' => '028-1234-5678',
				'email' => 'info@paradise-resort.com',
				'rating' => 4.8,
				'status' => 'active',
				'category_id' => 1,
				'star_rating' => 5,
				'website' => 'https://paradise-resort.com',
				'latitude' => '10.7769',
				'longitude' => '106.7009',
				'province_id' => 1,
				'ward_id' => 1,
				'city' => 'TP. Hồ Chí Minh',
				// New fields
				'checkin_time' => '14:00',
				'checkout_time' => '12:00',
				'manager_name' => 'Nguyễn Văn A',
				'manager_phone' => '0901234567',
				'wifi_password' => 'paradise2024',
				'facebook' => 'https://facebook.com/paradise-resort',
				'instagram' => 'https://instagram.com/paradise_resort',
				'is_featured' => 1,
				'cancellation_policy' => 'Hủy miễn phí trước 24h, phí 50% trong 24h',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			),
			array(
				'name' => 'Khách sạn City Center',
				'description' => 'Khách sạn 4 sao tại trung tâm thành phố',
				'address' => '456 Đường Trung Tâm, Phường 2',
				'country' => 'Việt Nam',
				'phone' => '028-8765-4321',
				'email' => 'info@city-center.com',
				'rating' => 4.5,
				'status' => 'active',
				'category_id' => 2,
				'star_rating' => 4,
				'website' => 'https://city-center.com',
				'latitude' => '10.7769',
				'longitude' => '106.7009',
				'province_id' => 1,
				'ward_id' => 2,
				'city' => 'TP. Hồ Chí Minh',
				// New fields
				'checkin_time' => '15:00',
				'checkout_time' => '11:00',
				'manager_name' => 'Trần Thị B',
				'manager_phone' => '0907654321',
				'wifi_password' => 'city2024',
				'facebook' => 'https://facebook.com/city-center-hotel',
				'instagram' => 'https://instagram.com/city_center_hotel',
				'is_featured' => 0,
				'cancellation_policy' => 'Hủy miễn phí trước 48h',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			)
		);

		foreach ($hotels_data as $hotel) {
			\DB::query('INSERT INTO hotels (name, description, address, country, phone, email, rating, status, category_id, star_rating, website, latitude, longitude, province_id, ward_id, city, checkin_time, checkout_time, manager_name, manager_phone, wifi_password, facebook, instagram, is_featured, cancellation_policy, created_at, updated_at) 
				VALUES (:name, :description, :address, :country, :phone, :email, :rating, :status, :category_id, :star_rating, :website, :latitude, :longitude, :province_id, :ward_id, :city, :checkin_time, :checkout_time, :manager_name, :manager_phone, :wifi_password, :facebook, :instagram, :is_featured, :cancellation_policy, :created_at, :updated_at)')
				->parameters($hotel)
				->execute();
		}

		// Add sample rooms
		$rooms_data = array(
			array(
				'hotel_id' => 1,
				'name' => 'Phòng Double Ocean View',
				'description' => 'Phòng đôi sang trọng với view biển tuyệt đẹp',
				'room_type' => 'double',
				'price' => 800000,
				'capacity' => 3, // Add capacity field
				'status' => 'active',
				'floor_number' => 5,
				'room_number' => '501',
				'max_occupancy' => 3,
				'adult_capacity' => 2,
				'child_capacity' => 1,
				'smoking_allowed' => 0,
				'balcony' => 1,
				'sea_view' => 1,
				'city_view' => 0,
				'garden_view' => 0,
				'air_conditioning' => 1,
				'minibar' => 1,
				'safe' => 1,
				'wifi' => 1,
				'tv' => 1,
				'room_service' => 1,
				'breakfast_included' => 1,
				'is_featured' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			),
			array(
				'hotel_id' => 1,
				'name' => 'Phòng Single City View',
				'description' => 'Phòng đơn tiêu chuẩn với view thành phố',
				'room_type' => 'single',
				'price' => 400000,
				'capacity' => 2, // Add capacity field
				'status' => 'active',
				'floor_number' => 3,
				'room_number' => '301',
				'max_occupancy' => 2,
				'adult_capacity' => 2,
				'child_capacity' => 0,
				'smoking_allowed' => 0,
				'balcony' => 0,
				'sea_view' => 0,
				'city_view' => 1,
				'garden_view' => 0,
				'air_conditioning' => 1,
				'minibar' => 0,
				'safe' => 1,
				'wifi' => 1,
				'tv' => 1,
				'room_service' => 0,
				'breakfast_included' => 0,
				'is_featured' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			),
			array(
				'hotel_id' => 2,
				'name' => 'Phòng Family Suite',
				'description' => 'Phòng suite dành cho gia đình',
				'room_type' => 'suite',
				'price' => 1200000,
				'capacity' => 4, // Add capacity field
				'status' => 'active',
				'floor_number' => 10,
				'room_number' => '1001',
				'max_occupancy' => 4,
				'adult_capacity' => 2,
				'child_capacity' => 2,
				'smoking_allowed' => 0,
				'balcony' => 1,
				'sea_view' => 0,
				'city_view' => 1,
				'garden_view' => 0,
				'air_conditioning' => 1,
				'minibar' => 1,
				'safe' => 1,
				'wifi' => 1,
				'tv' => 1,
				'room_service' => 1,
				'breakfast_included' => 1,
				'is_featured' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			)
		);

		foreach ($rooms_data as $room) {
			\DB::query('INSERT INTO rooms (hotel_id, name, description, room_type, price, capacity, status, floor_number, room_number, max_occupancy, adult_capacity, child_capacity, smoking_allowed, balcony, sea_view, city_view, garden_view, air_conditioning, minibar, safe, wifi, tv, room_service, breakfast_included, is_featured, created_at, updated_at) 
				VALUES (:hotel_id, :name, :description, :room_type, :price, :capacity, :status, :floor_number, :room_number, :max_occupancy, :adult_capacity, :child_capacity, :smoking_allowed, :balcony, :sea_view, :city_view, :garden_view, :air_conditioning, :minibar, :safe, :wifi, :tv, :room_service, :breakfast_included, :is_featured, :created_at, :updated_at)')
				->parameters($room)
				->execute();
		}
	}

	public function down()
	{
		\DB::query('DELETE FROM rooms WHERE hotel_id IN (1, 2)')->execute();
		\DB::query('DELETE FROM hotels WHERE id IN (1, 2)')->execute();
	}
}
