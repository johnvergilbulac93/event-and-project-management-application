<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function event()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(1); // 5 per page
        return $events;
    }
}
