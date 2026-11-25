<?php

namespace App\Http\Controllers;

use App\Models\Staff_Profile;
use App\Models\UserSystem;
use App\Models\Institution;
use Illuminate\Http\Request;

class StaffProfileController extends Controller
{
    public function index()
    {
        $staffProfiles = Staff_Profile::all();
        return response()->json($staffProfiles);
    }


    public function store(Request $request)
    {
        $staffProfiles = Staff_Profile::create($request->all());
        return response()->json($staffProfiles);
    }

    public function show($id)
    {
        $staffProfiles = Staff_Profile::find($id);
        return response()->json($staffProfiles);
    }


    public function update(Request $request, Staff_Profile $staffProfiles)
    {
        $staffProfiles->update($request->all());
        return response()->json($staffProfiles);
    }

    public function destroy(Staff_Profile $staffProfiles)
    {
        $staffProfiles->delete();
        return response()->json($staffProfiles);
    }
}