<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsSeeder extends Seeder
{
    public function run()
    {
        Event::truncate();

        $events = [
            [
                'title' => 'Профессиональная проба "IT-специалист"',
                'short_desc' => 'Попробуй себя в роли разработчика и узнай основы программирования',
                'full_desc' => json_encode([
                    'На мероприятии ты познакомишься с основами Python и создашь свою первую программу.',
                    'Узнаешь, какие навыки нужны IT-специалисту и как начать карьеру в этой сфере.',
                    'Практическое занятие с реальным разработчиком.'
                ]),
                'image' => 'it_probe.webp',
                'tag' => 'Профпроба',
                'type' => 'probe',
                'date' => json_encode(['day' => '15', 'month' => 'октября', 'year' => '2024']),
                'participants' => 20,
                'duration' => '2 часа'
            ],
            [
                'title' => 'Интерактивная игра "Сто к одному"',
                'short_desc' => 'Командная игра на знание профессий и soft skills',
                'full_desc' => json_encode([
                    'Увлекательная командная игра, где нужно угадывать самые популярные ответы.',
                    'Развивает коммуникативные навыки и умение работать в команде.',
                    'Призы и подарки для победителей!'
                ]),
                'image' => 'game.webp',
                'tag' => 'Игра',
                'type' => 'game',
                'date' => json_encode(['day' => '20', 'month' => 'октября', 'year' => '2024']),
                'participants' => 40,
                'duration' => '1.5 часа'
            ],
            [
                'title' => 'VR-тренажер "Виртуальная хирургия"',
                'short_desc' => 'Погрузись в мир медицины с помощью VR-технологий',
                'full_desc' => json_encode([
                    'Уникальная возможность попробовать себя в роли хирурга в виртуальной реальности.',
                    'Реалистичная симуляция с использованием VR-очков.',
                    'Помогает понять, подходит ли тебе медицинская специальность.'
                ]),
                'image' => 'vr_surgery.webp',
                'tag' => 'VR-тренажер',
                'type' => 'vr',
                'date' => json_encode(['day' => '25', 'month' => 'октября', 'year' => '2024']),
                'participants' => 10,
                'duration' => '30 минут'
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
