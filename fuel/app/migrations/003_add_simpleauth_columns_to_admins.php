<?php

namespace Fuel\Migrations;

class Add_simpleauth_columns_to_admins
{
	public function up(): void
	{
		\DB::query("ALTER TABLE `admins` ADD COLUMN `group` INT(11) NOT NULL DEFAULT 100 AFTER `status`")->execute();
		\DB::query("ALTER TABLE `admins` ADD COLUMN `last_login` INT(11) NULL AFTER `group`")->execute();
		\DB::query("ALTER TABLE `admins` ADD COLUMN `login_hash` VARCHAR(255) NULL AFTER `last_login`")->execute();
		\DB::query("ALTER TABLE `admins` ADD COLUMN `profile_fields` TEXT NULL AFTER `login_hash`")->execute();
	}

	public function down(): void
	{
		\DB::query("ALTER TABLE `admins` DROP COLUMN `profile_fields`")->execute();
		\DB::query("ALTER TABLE `admins` DROP COLUMN `login_hash`")->execute();
		\DB::query("ALTER TABLE `admins` DROP COLUMN `last_login`")->execute();
		\DB::query("ALTER TABLE `admins` DROP COLUMN `group`")->execute();
	}
}
