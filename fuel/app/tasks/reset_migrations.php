<?php

namespace Fuel\Tasks;

class Reset_Migrations
{
    public static function run(): void
    {
        try {
            \DB::query('DROP TABLE IF EXISTS migration')->execute();
            \Cli::write('Đã xóa bảng migration', 'green');

            \Cli::write('Bắt đầu chạy migrations...', 'yellow');
            \Migrate::latest();
            \Cli::write('Hoàn thành migrations!', 'green');
            
        } catch (\Exception $e) {
            \Cli::write('Lỗi: ' . $e->getMessage(), 'red');
        }
    }
}
