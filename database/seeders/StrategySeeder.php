<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Strategy;
use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = CarbonImmutable::now()->toDateTimeString();

        Strategy::insert([
            [
                'inputValue' => 'MOBILE',
                'name' => 'For Mobile Phone',
                'description' => 'Worldwide users at April 2024 by this device',
                'usedBy' => 59.57,
                'updated_at' => $now,
                'created_at' => $now
            ],
            [
                'inputValue' => 'DESKTOP',
                'name' => 'For Desktop PC',
                'description' => 'Worldwide users at April 2024 by this device',
                'usedBy' => 38.41,
                'updated_at' => $now,
                'created_at' => $now
            ],
        ]);
    }
}
