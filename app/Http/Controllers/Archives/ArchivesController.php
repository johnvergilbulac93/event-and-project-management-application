<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArchivesController extends Controller
{
    //

    public function userArchives(Request $request)
    {

        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");


        $users = User::query()
            ->onlyTrashed()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination



        return Inertia::render('barangay-record/archives/Archives', [
            'users' => $users,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
    }

    public function restore($id)
    {

        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
    }
}
