<?php
// database/seeders/AchievementSeeder.php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => '98%',    'subtitle' => 'Client Retention Rate', 'sort_order' => 1],
            ['title' => '20+',    'subtitle' => 'Country Served',         'sort_order' => 2],
            ['title' => '70+',    'subtitle' => 'Happy Clients',          'sort_order' => 3],
            ['title' => '30%',    'subtitle' => 'Increase in Leads',      'sort_order' => 4],
            ['title' => 'Top 10', 'subtitle' => 'Keywords Ranking',       'sort_order' => 5],
        ];

        foreach ($items as $item) {
            Achievement::updateOrCreate(
                ['title' => $item['title'], 'subtitle' => $item['subtitle']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}