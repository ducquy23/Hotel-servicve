<?php

namespace Fuel\Migrations;

class Update_room_type_enum
{
	public function up()
	{
		// Cập nhật ENUM values cho room_type
		\DB::query("ALTER TABLE rooms MODIFY COLUMN room_type ENUM('single', 'double', 'family', 'suite') NOT NULL")->execute();
	}

	public function down()
	{
		// Rollback về giá trị cũ
		\DB::query("ALTER TABLE rooms MODIFY COLUMN room_type ENUM('standard', 'deluxe', 'suite') NOT NULL")->execute();
	}
}
