<?php

namespace Fuel\Migrations;

class Update_admins_for_simpleauth
{
	public function up(): void
	{
		\DB::query("ALTER TABLE `admins` ADD COLUMN `salt` VARCHAR(255) NULL AFTER `password`")->execute();
		// Đổi kiểu created_at sang INT để lưu unix timestamp
		\DB::query("ALTER TABLE `admins` MODIFY COLUMN `created_at` INT(11) NOT NULL DEFAULT 0")->execute();
	}

	public function down(): void
	{
		\DB::query("ALTER TABLE `admins` MODIFY COLUMN `created_at` DATETIME NOT NULL")->execute();
		\DB::query("ALTER TABLE `admins` DROP COLUMN `salt`")->execute();
	}
}
