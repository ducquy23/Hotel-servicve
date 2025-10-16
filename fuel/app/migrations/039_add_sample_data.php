<?php

namespace Fuel\Migrations;

class Add_sample_data
{
	public function up()
	{
		// Add sample amenities (tiện ích & dịch vụ)
		$amenities_data = array(
			array('name' => 'WiFi miễn phí', 'description' => 'Kết nối internet tốc độ cao', 'icon' => 'wifi', 'category' => 'facility', 'price' => 0, 'service_type' => 'free', 'is_24h' => 1, 'operating_hours' => '24/7', 'status' => 'active'),
			array('name' => 'Bể bơi', 'description' => 'Bể bơi ngoài trời với view đẹp', 'icon' => 'pool', 'category' => 'facility', 'price' => 0, 'service_type' => 'free', 'is_24h' => 0, 'operating_hours' => '06:00 - 22:00', 'status' => 'active'),
			array('name' => 'Spa & Massage', 'description' => 'Dịch vụ spa và massage thư giãn', 'icon' => 'spa', 'category' => 'service', 'price' => 500000, 'service_type' => 'paid', 'is_24h' => 0, 'operating_hours' => '09:00 - 21:00', 'status' => 'active'),
			array('name' => 'Phòng gym', 'description' => 'Phòng tập gym hiện đại', 'icon' => 'gym', 'category' => 'facility', 'price' => 0, 'service_type' => 'free', 'is_24h' => 0, 'operating_hours' => '05:00 - 23:00', 'status' => 'active'),
			array('name' => 'Dịch vụ phòng', 'description' => 'Dịch vụ phòng 24/7', 'icon' => 'room-service', 'category' => 'service', 'price' => 100000, 'service_type' => 'paid', 'is_24h' => 1, 'operating_hours' => '24/7', 'status' => 'active'),
			array('name' => 'Bãi đỗ xe', 'description' => 'Bãi đỗ xe an toàn', 'icon' => 'parking', 'category' => 'facility', 'price' => 0, 'service_type' => 'free', 'is_24h' => 1, 'operating_hours' => '24/7', 'status' => 'active'),
		);

		foreach ($amenities_data as $amenity) {
			\DB::query('INSERT INTO amenities (name, description, icon, category, price, service_type, is_24h, operating_hours, status, created_at, updated_at) 
				VALUES (:name, :description, :icon, :category, :price, :service_type, :is_24h, :operating_hours, :status, NOW(), NOW())')
				->parameters($amenity)
				->execute();
		}

		// Add sample hotel policies
		$policies_data = array(
			array('hotel_id' => 1, 'policy_type' => 'checkin', 'title' => 'Giờ nhận phòng', 'description' => 'Nhận phòng từ 14:00, trả phòng trước 12:00', 'is_mandatory' => 1, 'display_order' => 1, 'status' => 'active'),
			array('hotel_id' => 1, 'policy_type' => 'cancellation', 'title' => 'Chính sách hủy', 'description' => 'Hủy miễn phí trước 24h, phí 50% trong 24h', 'is_mandatory' => 1, 'display_order' => 2, 'status' => 'active'),
			array('hotel_id' => 1, 'policy_type' => 'pets', 'title' => 'Chính sách thú cưng', 'description' => 'Không cho phép mang thú cưng', 'is_mandatory' => 0, 'display_order' => 3, 'status' => 'active'),
			array('hotel_id' => 1, 'policy_type' => 'smoking', 'title' => 'Chính sách hút thuốc', 'description' => 'Không hút thuốc trong phòng', 'is_mandatory' => 1, 'display_order' => 4, 'status' => 'active'),
		);

		foreach ($policies_data as $policy) {
			\DB::query('INSERT INTO hotel_policies (hotel_id, policy_type, title, description, is_mandatory, display_order, status, created_at, updated_at) 
				VALUES (:hotel_id, :policy_type, :title, :description, :is_mandatory, :display_order, :status, NOW(), NOW())')
				->parameters($policy)
				->execute();
		}

		// Add sample room availability
		$availability_data = array(
			array('room_id' => 1, 'date' => date('Y-m-d'), 'available_rooms' => 5, 'price_override' => null, 'status' => 'available', 'block_reason' => null),
			array('room_id' => 1, 'date' => date('Y-m-d', strtotime('+1 day')), 'available_rooms' => 3, 'price_override' => 1200000, 'status' => 'available', 'block_reason' => null),
			array('room_id' => 1, 'date' => date('Y-m-d', strtotime('+2 days')), 'available_rooms' => 0, 'price_override' => null, 'status' => 'sold_out', 'block_reason' => 'Hết phòng'),
			array('room_id' => 2, 'date' => date('Y-m-d'), 'available_rooms' => 2, 'price_override' => null, 'status' => 'available', 'block_reason' => null),
		);

		foreach ($availability_data as $availability) {
			\DB::query('INSERT INTO room_availability (room_id, date, available_rooms, price_override, status, block_reason, created_at, updated_at) 
				VALUES (:room_id, :date, :available_rooms, :price_override, :status, :block_reason, NOW(), NOW())')
				->parameters($availability)
				->execute();
		}
	}

	public function down()
	{
		// Remove sample data
		\DB::query('DELETE FROM room_availability WHERE room_id IN (1, 2)')->execute();
		\DB::query('DELETE FROM hotel_policies WHERE hotel_id = 1')->execute();
		\DB::query('DELETE FROM amenities WHERE name IN ("WiFi miễn phí", "Bể bơi", "Spa & Massage", "Phòng gym", "Dịch vụ phòng", "Bãi đỗ xe")')->execute();
	}
}
