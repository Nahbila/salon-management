<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Knotless Braids', 'target_gender' => 'female', 'price' => 60, 'duration_minutes' => 240],
            ['name' => 'Boho Braids', 'target_gender' => 'female', 'price' => 65, 'duration_minutes' => 270],
            ['name' => 'Cornrow Braids', 'target_gender' => 'female', 'price' => 40, 'duration_minutes' => 120],
            ['name' => '2 Braids', 'target_gender' => 'female', 'price' => 25, 'duration_minutes' => 45],
            ['name' => 'Simple/Natural Braids', 'target_gender' => 'female', 'price' => 30, 'duration_minutes' => 60],
            ['name' => 'Simple Braids', 'target_gender' => 'male', 'price' => 25, 'duration_minutes' => 45],
            ['name' => 'Styled Braids', 'target_gender' => 'male', 'price' => 30, 'duration_minutes' => 45],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name'], 'target_gender' => $service['target_gender']],
                $service
            );
        }
    }
}