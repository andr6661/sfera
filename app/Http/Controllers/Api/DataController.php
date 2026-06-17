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
                'details' => json_decode($dir->details, true),
                'image' => $dir->image,
                'imageUrl' => $dir->image ? asset($dir->image) : null,
                'created_at' => $dir->created_at,
                'updated_at' => $dir->updated_at,
            ];
        });

        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'shortDesc' => $event->short_desc,
                'fullDesc' => json_decode($event->full_desc, true),
                'image' => $event->image,
                'imageUrl' => $event->image ? asset($event->image) : null,
                'tag' => $event->tag,
                'type' => $event->type,
                'date' => json_decode($event->date, true),
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
            $path = $request->file('img')->store('img', 'public');
            return response()->json([
                'success' => true,
                'path' => '/storage/' . $path
            ]);
        }
        return response()->json(['success' => false], 400);
    }

    public function updateDirections(Request $request)
    {
        $this->disableCache();
        $directions = $request->all();

        Direction::truncate();
        foreach ($directions as $item) {
            if (empty($item['title'])) {
                continue;
            }

            $directionData = [
                'title' => $item['title'] ?? '',
                'short_desc' => $item['shortDesc'] ?? '',
                'image' => $item['image'] ?? '',
            ];

            if (isset($item['details'])) {
                $directionData['details'] = is_array($item['details'])
                    ? json_encode($item['details'])
                    : $item['details'];
            } else {
                $directionData['details'] = json_encode([]);
            }

            Direction::create($directionData);
        }

        return response()->json(['success' => true]);
    }

    public function updateEvents(Request $request)
    {
        $this->disableCache();
        $events = $request->all();

        Event::truncate();
        foreach ($events as $item) {
            $eventData = [
                'title' => $item['title'] ?? '',
                'short_desc' => $item['shortDesc'] ?? '',
                'image' => $item['image'] ?? '',
                'tag' => $item['tag'] ?? '',
                'type' => $item['type'] ?? '',
                'participants' => $item['participants'] ?? 0,
                'duration' => $item['duration'] ?? '',
                'date_string' => $item['dateString'] ?? null,
            ];

            if (isset($item['fullDesc'])) {
                $eventData['full_desc'] = is_array($item['fullDesc'])
                    ? json_encode($item['fullDesc'])
                    : $item['fullDesc'];
            } else {
                $eventData['full_desc'] = json_encode([]);
            }

            if (isset($item['date'])) {
                $eventData['date'] = is_array($item['date'])
                    ? json_encode($item['date'])
                    : $item['date'];
            } else {
                $eventData['date'] = json_encode(['day' => '', 'month' => '', 'year' => '']);
            }

            Event::create($eventData);
        }

        return response()->json(['success' => true]);
    }

    public function updateStatistics(Request $request)
    {
        $this->disableCache();
        $data = $request->all();

        if (isset($data['case1']) && isset($data['case2']) && isset($data['case3'])) {
            Statistic::updateOrCreate(['key' => 'case1'], ['value' => $data['case1']['value'], 'title' => $data['case1']['title']]);
            Statistic::updateOrCreate(['key' => 'case2'], ['value' => $data['case2']['value'], 'title' => $data['case2']['title']]);
            Statistic::updateOrCreate(['key' => 'case3'], ['value' => $data['case3']['value'], 'title' => $data['case3']['title']]);
        } else {
            foreach ($data as $key => $stat) {
                Statistic::updateOrCreate(['key' => $key], ['value' => $stat['value'], 'title' => $stat['title']]);
            }
        }

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
