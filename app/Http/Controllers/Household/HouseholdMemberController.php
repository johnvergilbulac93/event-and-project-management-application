<?php

namespace App\Http\Controllers\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\Household\HouseholdRequest;
use App\Models\HouseHoldMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HouseholdMemberController extends Controller
{
    public function index($id)
    {
        $household = HouseHoldMember::where('user_id', $id)->get();
        return Inertia::render('user/HouseHoldMember', ['househead_id' => $id, 'household' => $household]);
    }
    public function store(HouseholdRequest $request)
    {
        HouseHoldMember::create($request->validated());
    }
    public function destroy($id)
    {
        $household = HouseHoldMember::find($id);
        $household->delete();
    }
    public function update(HouseholdRequest $request,$id) {
        HouseHoldMember::whereId($id)->update($request->validated());
    }
}
