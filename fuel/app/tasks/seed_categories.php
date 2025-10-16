<?php

namespace Fuel\Tasks;

class Seed_Categories
{
    public static function run(): void
    {
        $seed_rows = [
            [
                'name' => 'Resort',
                'description' => 'Khu nghỉ dưỡng cao cấp với nhiều tiện ích và dịch vụ.',
                'icon' => 'sun',
                'status' => 'active',
            ],
            [
                'name' => 'Hotel',
                'description' => 'Khách sạn tiêu chuẩn với đầy đủ dịch vụ cơ bản.',
                'icon' => 'home',
                'status' => 'active',
            ],
            [
                'name' => 'Motel',
                'description' => 'Nhà nghỉ giá rẻ, phù hợp cho khách du lịch bụi.',
                'icon' => 'map-pin',
                'status' => 'active',
            ],
            [
                'name' => 'Hostel',
                'description' => 'Nhà trọ tập thể, phù hợp cho khách trẻ tuổi.',
                'icon' => 'users',
                'status' => 'active',
            ],
            [
                'name' => 'Villa',
                'description' => 'Biệt thự riêng tư, lý tưởng cho gia đình và nhóm bạn.',
                'icon' => 'house',
                'status' => 'active',
            ],
            [
                'name' => 'Boutique Hotel',
                'description' => 'Khách sạn boutique với thiết kế độc đáo và phong cách riêng.',
                'icon' => 'star',
                'status' => 'active',
            ],
            [
                'name' => 'Business Hotel',
                'description' => 'Khách sạn công vụ, phù hợp cho khách đi công tác.',
                'icon' => 'briefcase',
                'status' => 'active',
            ],
            [
                'name' => 'Luxury Hotel',
                'description' => 'Khách sạn sang trọng 5 sao với dịch vụ cao cấp.',
                'icon' => 'award',
                'status' => 'active',
            ],
        ];

        try {
            \DB::start_transaction();

            foreach ($seed_rows as $row) {
                $exists = \DB::query("SELECT id FROM categories WHERE name = :name LIMIT 1")
                    ->parameters([':name' => $row['name']])
                    ->execute();

                if (count($exists) === 0) {
                    \DB::query('INSERT INTO categories (name, description, icon, status, created_at, updated_at) VALUES (:name, :desc, :icon, :status, NOW(), NOW())')
                        ->parameters(array(
                            ':name' => $row['name'],
                            ':desc' => $row['description'],
                            ':icon' => $row['icon'],
                            ':status' => $row['status'],
                        ))
                        ->execute();
                }
            }

            \DB::commit_transaction();
            \Cli::write('Seed categories: done', 'green');
        } catch (\Exception $e) {
            if (\DB::in_transaction()) { \DB::rollback_transaction(); }
            \Cli::write('Seed categories: failed - ' . $e->getMessage(), 'red');
        }
    }
}
