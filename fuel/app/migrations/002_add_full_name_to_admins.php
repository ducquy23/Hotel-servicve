<?php

namespace Fuel\Migrations;

class Add_full_name_to_admins
{
	public function up(): void
	{
		\DB::query("ALTER TABLE `admins` ADD COLUMN `full_name` VARCHAR(100) NULL AFTER `password`")->execute();
	}

	public function down(): void
	{
		\DB::query("ALTER TABLE `admins` DROP COLUMN `full_name`")->execute();
	}
}
