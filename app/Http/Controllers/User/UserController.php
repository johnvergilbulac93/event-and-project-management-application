<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");


        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('user/User', [
            'users' => $users,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    public function create()
    {
        return Inertia::render('user/UserForm');
    }

    public function store(UserFormRequest $request)
    {
        $user = $request->validated();
        $user['password'] = '12345678';
        User::create($user);
        return redirect()->route('user.index')
            ->with('message', 'Successfully saved.');
    }

    public function updateIndex($id)
    {
        return Inertia::render('user/UserForm', [
            'users' => User::findOrFail($id)
        ]);
    }

    public function update(UserFormRequest $request, $id)
    {

        User::whereId($id)->update($request->validated());
        return redirect()->route('user.index')
            ->with('message', 'Successfully updated.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
