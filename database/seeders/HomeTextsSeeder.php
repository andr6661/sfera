<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeText;

class HomeTextsSeeder extends Seeder
{
    public function run()
    {
        HomeText::truncate();

        $texts = [
            [
                'key' => 'heroText',
                'value' => 'Погрузись в мир профессий с мультимедийным парком "Сфера"'
            ],
            [
                'key' => 'aboutTitle',
                'value' => 'О мультимедийном парке "Сфера"'
            ],
            [
                'key' => 'aboutText',
                'value' => 'Сфера — это инновационное пространство, где школьники могут познакомиться с современными профессиями в интерактивном формате. VR-тренажеры, профпробы, квесты и мастер-классы помогут тебе найти свой путь!'
            ],
            [
                'key' => 'footerCopyright',
                'value' => '© 2026 ГБПОУ Нижегородский Губернский колледж'
            ],
            [
                'key' => 'footerEmail',
                'value' => 'sfera@ngknn.ru'
            ]
        ];

        foreach ($texts as $text) {
            HomeText::create($text);
        }
    }
}
