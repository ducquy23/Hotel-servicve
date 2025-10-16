<?php

namespace Fuel\Migrations;

class Add_basic_data
{
	public function up()
	{
		// Add basic user if not exists
		$user_exists = \DB::query('SELECT id FROM users WHERE id = 1')->execute()->as_array();
		if (empty($user_exists)) {
			\DB::query('INSERT INTO users (id, name, email, full_name, password, phone, role, created_at, updated_at) 
				VALUES (1, "admin", "admin@example.com", "Admin User", "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi", "0901234567", "customer", NOW(), NOW())')
				->execute();
		}

		// Add basic categories if not exists
		$category_exists = \DB::query('SELECT id FROM categories WHERE id = 1')->execute()->as_array();
		if (empty($category_exists)) {
			\DB::query('INSERT INTO categories (id, name, description, status, created_at, updated_at) 
				VALUES (1, "Resort", "Khách sạn resort", "active", NOW(), NOW())')
				->execute();
		}

		$category_exists = \DB::query('SELECT id FROM categories WHERE id = 2')->execute()->as_array();
		if (empty($category_exists)) {
			\DB::query('INSERT INTO categories (id, name, description, status, created_at, updated_at) 
				VALUES (2, "Hotel", "Khách sạn thông thường", "active", NOW(), NOW())')
				->execute();
		}

		// Add basic provinces and wards if not exists
		$province_exists = \DB::query('SELECT id FROM provinces WHERE id = 1')->execute()->as_array();
		if (empty($province_exists)) {
			\DB::query('INSERT INTO provinces (id, name, created_at, updated_at) 
				VALUES (1, "TP. Hồ Chí Minh", NOW(), NOW())')
				->execute();
		}

		$ward_exists = \DB::query('SELECT id FROM wards WHERE id = 1')->execute()->as_array();
		if (empty($ward_exists)) {
			\DB::query('INSERT INTO wards (id, name, province_id, created_at, updated_at) 
				VALUES (1, "Phường 1", 1, NOW(), NOW())')
				->execute();
		}

		$ward_exists = \DB::query('SELECT id FROM wards WHERE id = 2')->execute()->as_array();
		if (empty($ward_exists)) {
			\DB::query('INSERT INTO wards (id, name, province_id, created_at, updated_at) 
				VALUES (2, "Phường 2", 1, NOW(), NOW())')
				->execute();
		}
	}

	public function down()
	{
		// Remove basic data
		\DB::query('DELETE FROM users WHERE id = 1')->execute();
		\DB::query('DELETE FROM categories WHERE id IN (1, 2)')->execute();
		\DB::query('DELETE FROM provinces WHERE id = 1')->execute();
		\DB::query('DELETE FROM wards WHERE id IN (1, 2)')->execute();
	}
}
