<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUserFormRequest;
use App\Http\Requests\User\UserFormRequest;
use App\Models\HouseHoldHead;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileAccountController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");

        $users = HouseHoldHead::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('barangay-record/profile-account/ProfileAccount', [
            'users' => $users,
            'filters' => [
                'search' => $search,
            ]
        ]);

        // return Inertia::render('barangay-record/profile-account/ProfileAccount');
    }
    public function create()
    {
        return Inertia::render('barangay-record/profile-account/Form');
    }

    public function store(ProfileUserFormRequest $request)
    {
        $user = $request->validated();
        HouseHoldHead::create($user);
        return redirect()->route('barangay-record.profile-account')
            ->with('message', 'Successfully saved.');
    }

    public function updateIndex($id)
    {
        return Inertia::render('barangay-record/profile-account/Form', [
            'users' => HouseHoldHead::findOrFail($id)
        ]);
    }

    public function update(ProfileUserFormRequest $request, $id)
    {

        HouseHoldHead::whereId($id)->update($request->validated());
        return redirect()->route('barangay-record.profile-account')
            ->with('message', 'Successfully updated.');
    }
    public function destroy($id)
    {
        $user = HouseHoldHead::findOrFail($id);
        $user->delete();
    }
}
