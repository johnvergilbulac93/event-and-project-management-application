<?php

namespace App\Http\Controllers\Attendance;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
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
            ->where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('attendance/Attendance', [
            'events' => $events,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    public function create($id)
    {
        $event = Event::findOrFail($id);
        return Inertia::render('attendance/AttendanceForm', ['event' => $event]);
    }
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 422);
        }
        $attendance = Attendance::where('event_id', $request->event_id)
            ->where('user_id', $user->id)
            ->first();
        if ($attendance) {
            return response()->json([
                'message' => 'Attendance already recorded.',
                'user' => $user,
            ], 200); // Or 409 Conflict
        }
        if (!$attendance) {
            Attendance::create([
                'event_id' => $request->event_id,
                'user_id' => $user->id,
            ]);
        }
        return response()->json([
            'message' => 'Attendance recorded.',
            'user' => $user,
        ]);
    }
    public function listOfAttendees(Request $request, $event_id)
    {
        $search = $request->search;

        $attendances = Attendance::with(['event', 'user'])
            ->where('event_id', $event_id)
            ->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });

        return $attendances->paginate();
    }
}
