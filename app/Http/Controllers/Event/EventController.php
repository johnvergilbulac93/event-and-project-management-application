<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventFormRequest;
use App\Http\Requests\User\UserFormRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");


        $events = Event::query()
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('event/Event', [
            'events' => $events,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    public function create()
    {
        return Inertia::render('event/EventForm');
    }

    public function store(EventFormRequest $request)
    {
        $event = $request->validated();
        Event::create($event);
        return redirect()->route('event.index')
            ->with('message', 'Successfully saved.');
    }

    public function updateIndex($id)
    {
        return Inertia::render('event/EventForm', [
            'events' => Event::findOrFail($id)
        ]);
    }

    public function update(EventFormRequest $request, $id)
    {
        Event::whereId($id)->update($request->validated());
        return redirect()->route('event.index')
            ->with('message', 'Successfully updated.');
    }
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
    }
}
