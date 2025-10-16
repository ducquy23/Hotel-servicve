<?php

namespace Fuel\Tasks;

use Fuel\Core\Database_Exception;
use Fuel\Core\DB;

class Dbtest
{
    public static function run()
    {
        try {
            $result = DB::query('SELECT id,name FROM users', DB::SELECT)
                ->execute();

            if (count($result) > 0) {
                echo "✅ Kết nối thành công!\n";
            } else {
                echo "⚠️ Kết nối được nhưng không có kết quả.\n";
            }
        } catch (Database_Exception $e) {
            echo "❌ Lỗi kết nối DB: " . $e->getMessage() . "\n";
        }
    }
}
