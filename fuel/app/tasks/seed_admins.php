<?php

namespace Fuel\Tasks;

/**
 * Seeder cho bảng admins
 * Chạy: php oil r seed_admins
 */
class Seed_Admins
{
	public static function run(): void
	{
		$now_ts = time();

		$seed_rows = [
			[
				'username' => 'admin',
				'email' => 'admin@example.com',
				'password' => 'admin123',
				'full_name' => 'System Administrator',
				'group' => 100,
			],
			[
				'username' => 'owner',
				'email' => 'owner@example.com',
				'password' => 'owner123',
				'full_name' => 'Project Owner',
				'group' => 100,
			],
		];

		try {
			// Đảm bảo bảng tồn tại (schema tối thiểu cho Simpleauth)
			$sql_create = "
				CREATE TABLE IF NOT EXISTS `admins` (
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`username` VARCHAR(50) NOT NULL,
					`email` VARCHAR(100) NOT NULL,
					`password` VARCHAR(255) NOT NULL,
					`status` VARCHAR(40) NOT NULL DEFAULT 'active',
					`group` INT(11) NOT NULL DEFAULT 100,
					`last_login` INT(11) NULL,
					`login_hash` VARCHAR(255) NULL,
					`profile_fields` TEXT NULL,
					`created_at` INT(11) NOT NULL DEFAULT 0,
					`updated_at` DATETIME NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `uq_admins_username` (`username`),
					UNIQUE KEY `uq_admins_email` (`email`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
			";
			\DB::query($sql_create)->execute();

			\DB::start_transaction();

			$sql_check = "SELECT id FROM admins WHERE username = :username LIMIT 1";
			$sql_update_active = "UPDATE admins SET status = 'active', updated_at = NOW() WHERE id = :id";

			foreach ($seed_rows as $row) {
				$exists = \DB::query($sql_check)->parameters([':username' => $row['username']])->execute();

				if (count($exists) === 0) {
					$uid = \Auth::create_user($row['username'], $row['password'], $row['email'], $row['group']);
					
					// Cập nhật full_name
					\DB::query("UPDATE admins SET full_name = :fn, created_at = :c WHERE id = :id")
						->parameters(array(
							':fn' => $row['full_name'],
							':c' => $now_ts, 
							':id' => $uid
						))
						->execute();
				} else {
					$uid = (int) $exists->current()['id'];
				}

				\DB::query($sql_update_active)
					->parameters([':id' => $uid])
					->execute();
			}

			\DB::commit_transaction();
			\Cli::write('Seed admins with Auth: done', 'green');
		} catch (\Exception $e) {
			if (\DB::in_transaction()) { \DB::rollback_transaction(); }
			\Cli::write('Seed admins: failed - ' . $e->getMessage(), 'red');
		}
	}
}
