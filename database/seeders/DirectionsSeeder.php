<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Direction;

class DirectionsSeeder extends Seeder
{
    public function run()
    {
        Direction::truncate();

        $directions = [
            [
                'title' => 'Профессиональные пробы',
                'short_desc' => 'Попробуйте себя в реальной профессии в интерактивном формате',
                'details' => json_encode(['IT-специалист', 'Бухгалтер', 'Медицинский работник', 'Инженер', 'Педагог']),
                'image' => 'probe.webp'
            ],
            [
                'title' => 'Интерактивные игры',
                'short_desc' => 'Командные игры для развития soft skills и знакомства с профессиями',
                'details' => json_encode(['Сто к одному', 'Что Где Когда', 'Брейн-ринг', 'Крокодил', 'Дебаты']),
                'image' => 'game.webp'
            ],
            [
                'title' => 'VR-тренажеры',
                'short_desc' => 'Погружение в профессию через технологии виртуальной реальности',
                'details' => json_encode(['VR-хирургия', 'VR-архитектор', 'VR-сварщик', 'VR-пилот', 'VR-дизайнер']),
                'image' => 'vr.webp'
            ],
            [
                'title' => 'Квесты',
                'short_desc' => 'Командные приключения с профессиональным уклоном',
                'details' => json_encode(['Поиск призвания', 'Профессия будущего', 'Лабиринт карьеры', 'Тайм-менеджмент', 'Стартап']),
                'image' => 'quest.webp'
            ],
            [
                'title' => 'Мастер-классы',
                'short_desc' => 'Практические занятия от действующих профессионалов',
                'details' => json_encode(['Цифровой дизайн', 'Робототехника', 'Кулинарное дело', 'Фотография', 'Программирование']),
                'image' => 'master.webp'
            ],
            [
                'title' => 'Лекции и встречи',
                'short_desc' => 'Общение с экспертами и представителями разных профессий',
                'details' => json_encode(['Карьерные встречи', 'Лекции о профессиях', 'Панельные дискуссии', 'Мотивационные встречи', 'Ярмарка вакансий']),
                'image' => 'lecture.webp'
            ]
        ];

        foreach ($directions as $dir) {
            Direction::create($dir);
        }
    }
}
