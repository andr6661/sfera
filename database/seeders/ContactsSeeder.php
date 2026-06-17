<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeeder extends Seeder
{
    public function run()
    {
        Contact::truncate();

        $contacts = [
            [
                'key' => 'phone',
                'value' => '+7 (831) 123-45-67'
            ],
            [
                'key' => 'email',
                'value' => 'sfera@ngknn.ru'
            ],
            [
                'key' => 'address',
                'value' => 'г. Нижний Новгород, Московское шоссе, 1'
            ],
            [
                'key' => 'workHours',
                'value' => 'Пн-Пт: 9:00 - 18:00, Сб: 10:00 - 15:00'
            ],
            [
                'key' => 'howToGet.metro',
                'value' => 'станция "Московская" — 10 минут пешком'
            ],
            [
                'key' => 'howToGet.buses',
                'value' => '№1, 3, 5, 10, 25 — остановка "Московское шоссе"'
            ],
            [
                'key' => 'howToGet.parking',
                'value' => 'Бесплатная парковка на территории колледжа'
            ]
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
