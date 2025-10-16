<?php

namespace Fuel\Tasks;

class Seed_Amenities
{
    /**
     * Tạo dữ liệu tiện ích mẫu
     */
    public static function run(): void
    {
        $seed_rows = [
            ['name' => 'Wi-Fi miễn phí', 'description' => 'Internet tốc độ cao miễn phí', 'icon' => 'wifi', 'category' => 'general', 'status' => 'active'],
            ['name' => 'Bãi đỗ xe', 'description' => 'Bãi đỗ xe trong khuôn viên', 'icon' => 'truck', 'category' => 'facility', 'status' => 'active'],
            ['name' => 'Hồ bơi', 'description' => 'Hồ bơi ngoài trời', 'icon' => 'droplet', 'category' => 'facility', 'status' => 'active'],
            ['name' => 'Phòng gym', 'description' => 'Phòng tập thể dục đầy đủ thiết bị', 'icon' => 'activity', 'category' => 'facility', 'status' => 'active'],
            ['name' => 'Dịch vụ phòng', 'description' => 'Phục vụ đồ ăn, nước uống tận phòng', 'icon' => 'coffee', 'category' => 'service', 'status' => 'active'],
            ['name' => 'Đưa đón sân bay', 'description' => 'Xe đưa đón sân bay', 'icon' => 'navigation', 'category' => 'service', 'status' => 'active'],
            ['name' => 'Điều hòa', 'description' => 'Điều hòa nhiệt độ trong phòng', 'icon' => 'wind', 'category' => 'room', 'status' => 'active'],
            ['name' => 'Tivi', 'description' => 'Tivi màn hình phẳng', 'icon' => 'tv', 'category' => 'room', 'status' => 'active'],
        ];

        try {
            \DB::start_transaction();

            foreach ($seed_rows as $row) {
                $exists = \DB::query("SELECT id FROM amenities WHERE name = :name LIMIT 1")
                    ->parameters([':name' => $row['name']])
                    ->execute();

                if (count($exists) === 0) {
                    \DB::query('INSERT INTO amenities (name, description, icon, category, status, created_at, updated_at) VALUES (:name, :desc, :icon, :cat, :status, NOW(), NOW())')
                        ->parameters(array(
                            ':name' => $row['name'],
                            ':desc' => $row['description'],
                            ':icon' => $row['icon'],
                            ':cat' => $row['category'],
                            ':status' => $row['status'],
                        ))
                        ->execute();
                }
            }

            \DB::commit_transaction();
            \Cli::write('Seed amenities: done', 'green');
        } catch (\Exception $e) {
            if (\DB::in_transaction()) { \DB::rollback_transaction(); }
            \Cli::write('Seed amenities: failed - ' . $e->getMessage(), 'red');
        }
    }
}


