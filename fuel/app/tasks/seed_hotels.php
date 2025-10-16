<?php

namespace Fuel\Tasks;

/**
 * Seeder cho bảng hotels
 * Chạy: php oil r seed_hotels
 */
class Seed_Hotels
{
	public static function run(): void
	{
		$seed_rows = [
			[
				'name' => 'Hotel Saigon',
				'description' => 'Khách sạn 5 sao tại trung tâm thành phố Hồ Chí Minh',
				'address' => '123 Nguyễn Huệ, Quận 1',
				'city' => 'Hồ Chí Minh',
				'country' => 'Việt Nam',
				'phone' => '028-1234-5678',
				'email' => 'info@hotelsaigon.com',
				'rating' => 4.8,
				'status' => 'active',
			],
			[
				'name' => 'Hanoi Grand Hotel',
				'description' => 'Khách sạn sang trọng gần Hồ Gươm',
				'address' => '456 Lê Thái Tổ, Hoàn Kiếm',
				'city' => 'Hà Nội',
				'country' => 'Việt Nam',
				'phone' => '024-9876-5432',
				'email' => 'contact@hanoigrand.com',
				'rating' => 4.5,
				'status' => 'active',
			],
			[
				'name' => 'Da Nang Beach Resort',
				'description' => 'Resort nghỉ dưỡng bên bờ biển Đà Nẵng',
				'address' => '789 Bãi biển Mỹ Khê',
				'city' => 'Đà Nẵng',
				'country' => 'Việt Nam',
				'phone' => '0236-5555-7777',
				'email' => 'resort@danangbeach.com',
				'rating' => 4.7,
				'status' => 'active',
			],
			[
				'name' => 'Nha Trang Paradise',
				'description' => 'Khách sạn view biển tại Nha Trang',
				'address' => '321 Trần Phú, Nha Trang',
				'city' => 'Nha Trang',
				'country' => 'Việt Nam',
				'phone' => '0258-3333-9999',
				'email' => 'paradise@nhatrang.com',
				'rating' => 4.3,
				'status' => 'active',
			],
			[
				'name' => 'Phu Quoc Island Resort',
				'description' => 'Resort đảo Phú Quốc với view biển tuyệt đẹp',
				'address' => '654 Bãi Trường, Phú Quốc',
				'city' => 'Phú Quốc',
				'country' => 'Việt Nam',
				'phone' => '0297-7777-8888',
				'email' => 'island@phuquocresort.com',
				'rating' => 4.9,
				'status' => 'active',
			],
			[
				'name' => 'Hoi An Ancient Hotel',
				'description' => 'Khách sạn cổ kính tại phố cổ Hội An',
				'address' => '987 Nguyễn Thái Học, Hội An',
				'city' => 'Hội An',
				'country' => 'Việt Nam',
				'phone' => '0235-4444-6666',
				'email' => 'ancient@hoianhotel.com',
				'rating' => 4.6,
				'status' => 'inactive',
			],
		];

		try {
			\DB::start_transaction();

			$sql_check = "SELECT id FROM hotels WHERE name = :name LIMIT 1";
			$sql_insert = "INSERT INTO hotels (name, description, address, city, country, phone, email, rating, status, created_at, updated_at) VALUES (:name, :desc, :addr, :city, :country, :phone, :email, :rating, :status, NOW(), NOW())";

			foreach ($seed_rows as $row) {
				$exists = \DB::query($sql_check)->parameters([':name' => $row['name']])->execute();

				if (count($exists) === 0) {
					\DB::query($sql_insert)->parameters([
						':name' => $row['name'],
						':desc' => $row['description'],
						':addr' => $row['address'],
						':city' => $row['city'],
						':country' => $row['country'],
						':phone' => $row['phone'],
						':email' => $row['email'],
						':rating' => $row['rating'],
						':status' => $row['status'],
					])->execute();
				}
			}

			\DB::commit_transaction();
			\Cli::write('Seed hotels: done', 'green');
		} catch (\Exception $e) {
			if (\DB::in_transaction()) { \DB::rollback_transaction(); }
			\Cli::write('Seed hotels: failed - ' . $e->getMessage(), 'red');
		}
	}
}
