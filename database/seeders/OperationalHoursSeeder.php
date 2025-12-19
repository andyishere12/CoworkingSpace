<?php

namespace Database\Seeders;

use App\Models\OperationalHour;
use Illuminate\Database\Seeder;

class OperationalHoursSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            ['day' => 'Senin', 'open_time' => '08:00', 'close_time' => '16:00', 'is_closed' => false],
            ['day' => 'Selasa', 'open_time' => '08:00', 'close_time' => '16:00', 'is_closed' => false],
            ['day' => 'Rabu', 'open_time' => '08:00', 'close_time' => '16:00', 'is_closed' => false],
            ['day' => 'Kamis', 'open_time' => '08:00', 'close_time' => '16:00', 'is_closed' => false],
            ['day' => 'Jumat', 'open_time' => '08:00', 'close_time' => '15:00', 'is_closed' => false],
            ['day' => 'Sabtu', 'open_time' => '08:00', 'close_time' => '15:00', 'is_closed' => false],
            ['day' => 'Minggu', 'open_time' => null, 'close_time' => null, 'is_closed' => true],
        ];

        foreach ($days as $day) {
            OperationalHour::create($day);
        }
    }
}