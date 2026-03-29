<?php

namespace App\Http\Controllers\Report;

use App\Exports\Report\AttendanceExport;
use App\Exports\Report\EventExport;
use App\Exports\Report\FeedBackExport;
use App\Exports\Report\ProfileAccountExport;
use App\Exports\Report\ProjectExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $events = Event::select('id as value', 'title as label')->get();
        return Inertia::render('barangay-record/report/Report', ['events' => $events]);
    }
    public function getProfileAccount()
    {
        $users = User::select('first_name', 'middle_name', 'last_name', 'email', 'mobile_no', 'created_at')->get();
        return ['message' => 'success', 'data' => $users];
    }
    public function exportProfileAccount()
    {
        return Excel::download(new ProfileAccountExport(), 'profile_accounts.xlsx');
    }
    public function getFeedBack()
    {
        $users = Feedback::select('name', 'subject', 'comment', 'created_at')->get();
        return ['message' => 'success', 'data' => $users];
    }
    public function exportFeedBack()
    {
        return Excel::download(new FeedBackExport(), 'feedbacks.xlsx');
    }
    public function getEvent()
    {
        $users = Event::select('title', 'description', 'start_time', 'end_time', 'date', 'status', 'created_at')->get();
        return ['message' => 'success', 'data' => $users];
    }
    public function exportEvent()
    {
        return Excel::download(new EventExport(), 'events.xlsx');
    }
    public function getProject()
    {
        $users = Project::select('project_name', 'location', 'cost', 'start_date', 'completion_date', 'status')->get();
        return ['message' => 'success', 'data' => $users];
    }
    public function exportProject()
    {
        return Excel::download(new ProjectExport(), 'project.xlsx');
    }
    public function getAttendance($id)
    {
        $attendances =  Attendance::with('event', 'household')->where('event_id', $id)->get();
        return ['message' => 'success', 'data' => $attendances];
    }
    public function exportAttendance($id)
    {
        $attendances =  Attendance::with('event', 'household')->where('event_id', $id)->get();
        return Excel::download(new AttendanceExport($attendances), 'attendances.xlsx');
    }
}
