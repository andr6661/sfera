<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistic;

class StatisticsSeeder extends Seeder
{
    public function run()
    {
        Statistic::truncate();

        $statistics = [
            [
                'key' => 'case1',
                'value' => 40,
                'title' => 'Сценариев мероприятий'
            ],
            [
                'key' => 'case2',
                'value' => 100,
                'title' => 'Интерактивных игр'
            ],
            [
                'key' => 'case3',
                'value' => 2000,
                'title' => 'Гостей в год'
            ]
        ];

        foreach ($statistics as $stat) {
            Statistic::create($stat);
        }
    }
}
