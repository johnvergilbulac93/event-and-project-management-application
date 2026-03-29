<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");


        $feedbacks = Feedback::query()
            ->when($search, function ($query, $search) {
                $query->where('subject', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('barangay-record/feedback/Feedback', [
            'feedbacks' => $feedbacks,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    public function store(FeedbackRequest $request)
    {
        $feedback = $request->validated();
        Feedback::create($feedback);

        // return redirect()->route('welcome');
    }
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
    }
}
