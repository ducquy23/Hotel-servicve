<?php
// app/classes/constant/UserGroup.php
namespace Constant;

class UserGroup {
    const USER = 1;
    const MANAGER = 50;
    const ADMIN = 100;

    public static function name($value)
    {
        return match($value) {
            self::USER => 'Users',
            self::MANAGER => 'Managers',
            self::ADMIN => 'Administrators',
            default => 'Unknown',
        };
    }
}
