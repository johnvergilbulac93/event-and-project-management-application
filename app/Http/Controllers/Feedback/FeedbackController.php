<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    public function index()
    {
        return Inertia::render('barangay-record/feedback/Feedback');
    }
    public function store(FeedbackRequest $request)
    {
        $feedback = $request->validated();
        Feedback::create($feedback);

        // return redirect()->route('welcome');
    }
}
