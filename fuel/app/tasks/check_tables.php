<?php

namespace Fuel\Tasks;

class Check_Tables
{
    public static function run(): void
    {
        try {
            $tables = \DB::query('SHOW TABLES')->execute();
            \Cli::write('Các bảng trong database:', 'green');
            foreach ($tables as $table) {
                $table_name = array_values($table)[0];
                \Cli::write('- ' . $table_name, 'white');
            }
            $count = count($tables);
            \Cli::write("\nTổng số bảng: " . $count, 'yellow');
            
        } catch (\Exception $e) {
            \Cli::write('Lỗi: ' . $e->getMessage(), 'red');
        }
    }
}
