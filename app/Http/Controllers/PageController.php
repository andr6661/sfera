<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Direction;
use App\Models\Event;
use App\Models\Statistic;
use App\Models\HomeText;
use App\Models\Contact;

class PageController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'initialData' => [
                'homeTexts' => [
                    'heroText' => HomeText::where('key', 'heroText')->first()?->value,
                    'aboutTitle' => HomeText::where('key', 'aboutTitle')->first()?->value,
                    'aboutText' => HomeText::where('key', 'aboutText')->first()?->value,
                ],
                'statistics' => [
                    'case1' => Statistic::where('key', 'case1')->first(),
                    'case2' => Statistic::where('key', 'case2')->first(),
                    'case3' => Statistic::where('key', 'case3')->first(),
                ]
            ]
        ]);
    }

    public function directions()
    {
        $directions = Direction::all()->map(function($dir) {
            return [
                'id' => $dir->id,
                'title' => $dir->title,
                'shortDesc' => $dir->short_desc,
                'details' => json_decode($dir->details, true) ?? [],
                'image' => $dir->image,
            ];
        });

        return Inertia::render('DirectionsView', [
            'initialDirections' => $directions
        ]);
    }

    public function events()
    {
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'shortDesc' => $event->short_desc,
                'fullDesc' => json_decode($event->full_desc, true) ?? [],
                'image' => $event->image,
                'tag' => $event->tag,
                'type' => $event->type,
                'date' => json_decode($event->date, true) ?? ['day' => '', 'month' => '', 'year' => ''],
                'participants' => $event->participants,
                'duration' => $event->duration,
            ];
        });

        return Inertia::render('EventsView', [
            'initialEvents' => $events
        ]);
    }

    public function about()
    {
        return Inertia::render('AboutView');
    }

    public function contacts()
    {
        $contacts = [
            'phone' => Contact::where('key', 'phone')->first()?->value,
            'email' => Contact::where('key', 'email')->first()?->value,
            'address' => Contact::where('key', 'address')->first()?->value,
            'workHours' => Contact::where('key', 'workHours')->first()?->value,
            'howToGet' => [
                'metro' => Contact::where('key', 'howToGet.metro')->first()?->value,
                'buses' => Contact::where('key', 'howToGet.buses')->first()?->value,
                'parking' => Contact::where('key', 'howToGet.parking')->first()?->value,
            ]
        ];

        return Inertia::render('ContactsView', [
            'initialContacts' => $contacts
        ]);
    }
}
