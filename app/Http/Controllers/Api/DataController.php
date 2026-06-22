<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\Event;
use App\Models\Statistic;
use App\Models\HomeText;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    private function disableCache()
    {
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    public function getAllData()
    {
        $this->disableCache();

        $directions = Direction::all()->map(function($dir) {
            return [
                'id' => $dir->id,
                'title' => $dir->title,
                'shortDesc' => $dir->short_desc,
                'details' => json_decode($dir->details, true) ?? [],
                'image' => $dir->image,
                'imageUrl' => $dir->image ? asset(Storage::url($dir->image)) : null,
                'created_at' => $dir->created_at,
                'updated_at' => $dir->updated_at,
            ];
        });

        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'shortDesc' => $event->short_desc,
                'fullDesc' => json_decode($event->full_desc, true) ?? [],
                'image' => $event->image,
                'imageUrl' => $event->image ? asset(Storage::url($event->image)) : null,
                'tag' => $event->tag,
                'type' => $event->type,
                'date' => json_decode($event->date, true) ?? ['day' => '', 'month' => '', 'year' => ''],
                'dateString' => $event->date_string,
                'participants' => $event->participants,
                'duration' => $event->duration,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at,
            ];
        });

        return response()->json([
            'directions' => $directions,
            'events' => $events,
            'statistics' => [
                'case1' => Statistic::where('key', 'case1')->first(),
                'case2' => Statistic::where('key', 'case2')->first(),
                'case3' => Statistic::where('key', 'case3')->first(),
            ],
            'homeTexts' => [
                'heroText' => HomeText::where('key', 'heroText')->first()?->value,
                'aboutTitle' => HomeText::where('key', 'aboutTitle')->first()?->value,
                'aboutText' => HomeText::where('key', 'aboutText')->first()?->value,
                'footerCopyright' => HomeText::where('key', 'footerCopyright')->first()?->value,
                'footerEmail' => HomeText::where('key', 'footerEmail')->first()?->value,
            ],
            'contacts' => [
                'phone' => Contact::where('key', 'phone')->first()?->value,
                'email' => Contact::where('key', 'email')->first()?->value,
                'address' => Contact::where('key', 'address')->first()?->value,
                'workHours' => Contact::where('key', 'workHours')->first()?->value,
                'howToGet' => [
                    'metro' => Contact::where('key', 'howToGet.metro')->first()?->value,
                    'buses' => Contact::where('key', 'howToGet.buses')->first()?->value,
                    'parking' => Contact::where('key', 'howToGet.parking')->first()?->value,
                ]
            ]
        ]);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('img')) {
            // Сохраняем в папку public/img внутри storage
            $path = $request->file('img')->store('img', 'public');

            return response()->json([
                'success' => true,
                'path' => $path, // Сохраняем "img/filename.ext"
                'url' => asset(Storage::url($path)) // Ссылка для отображения на фронтенде
            ]);
        }
        return response()->json(['success' => false], 400);
    }

    public function updateDirections(Request $request)
    {
        $this->disableCache();
        $directions = $request->all();
        $keptIds = [];

        foreach ($directions as $item) {
            if (empty($item['title'])) {
                continue;
            }

            // Корректно упаковываем json-структуру деталей
            $details = isset($item['details'])
                ? (is_array($item['details']) ? json_encode($item['details']) : $item['details'])
                : json_encode([]);

            $direction = Direction::updateOrCreate(
                ['id' => $item['id'] ?? null],
                [
                    'title' => $item['title'] ?? '',
                    'short_desc' => $item['shortDesc'] ?? '',
                    'image' => $item['image'] ?? '',
                    'details' => $details
                ]
            );
            $keptIds[] = $direction->id;
        }

        // Удаляем только те записи, которые пользователь стёр в админке
        Direction::whereNotIn('id', $keptIds)->delete();

        return response()->json(['success' => true]);
    }

    public function updateEvents(Request $request)
    {
        $this->disableCache();
        $events = $request->all();
        $keptIds = [];

        foreach ($events as $item) {
            $fullDesc = isset($item['fullDesc'])
                ? (is_array($item['fullDesc']) ? json_encode($item['fullDesc']) : $item['fullDesc'])
                : json_encode([]);

            $date = isset($item['date'])
                ? (is_array($item['date']) ? json_encode($item['date']) : $item['date'])
                : json_encode(['day' => '', 'month' => '', 'year' => '']);

            $event = Event::updateOrCreate(
                ['id' => $item['id'] ?? null],
                [
                    'title' => $item['title'] ?? '',
                    'short_desc' => $item['shortDesc'] ?? '',
                    'image' => $item['image'] ?? '',
                    'tag' => $item['tag'] ?? '',
                    'type' => $item['type'] ?? '',
                    'participants' => $item['participants'] ?? 0,
                    'duration' => $item['duration'] ?? '',
                    'date_string' => $item['dateString'] ?? null,
                    'full_desc' => $fullDesc,
                    'date' => $date
                ]
            );
            $keptIds[] = $event->id;
        }

        Event::whereNotIn('id', $keptIds)->delete();

        return response()->json(['success' => true]);
    }

    public function updateStatistics(Request $request)
    {
        $this->disableCache();
        $data = $request->all();

        // Карта для точечного обновления
        $idMap = [
            'case1' => 1,
            'case2' => 2,
            'case3' => 3
        ];

        foreach ($data as $key => $stat) {
            // Игнорируем мусорные ключи, которые случайно прилетают с фронта
            if ($key === '[object Object]' || !is_array($stat)) {
                continue;
            }

            if (isset($idMap[$key])) {
                \DB::table('statistics')
                    ->where('id', $idMap[$key])
                    ->update([
                        'value' => (int)($stat['value'] ?? 0),
                        'title' => (string)($stat['title'] ?? ''),
                        'updated_at' => now()
                    ]);
            }
        }

        // На всякий случай удаляем любой мусор, который мог создаться ранее
        \DB::table('statistics')->where('key', '[object Object]')->delete();

        return response()->json(['success' => true]);
    }

    public function updateHomeTexts(Request $request)
    {
        $this->disableCache();
        foreach ($request->all() as $key => $value) {
            HomeText::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return response()->json(['success' => true]);
    }

    public function updateContacts(Request $request)
    {
        $this->disableCache();
        foreach ($request->all() as $key => $value) {
            Contact::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return response()->json(['success' => true]);
    }
}
