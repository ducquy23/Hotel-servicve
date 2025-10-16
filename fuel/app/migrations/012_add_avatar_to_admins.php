<?php

namespace Fuel\Migrations;

class Add_avatar_to_admins
{
    public function up(): void
    {
        \DBUtil::add_fields('admins', array(
            'avatar' => array('type' => 'varchar', 'constraint' => 255, 'null' => true, 'after' => 'full_name'),
        ));
    }

    public function down(): void
    {
        \DBUtil::drop_fields('admins', array('avatar'));
    }
}
