<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function event()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(3); // 5 per page
        return $events;
    }
    public function project()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(3); // 5 per page
        return $projects;
    }
}
