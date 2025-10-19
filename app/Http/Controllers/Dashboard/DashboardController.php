<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\HouseHoldMember;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'hHead' => User::where('role_id',  2)->count(),
            'hMember' => HouseHoldMember::count(),
            'event' => Event::count(),
            'project' => Project::count(),

        ]);
    }
}
