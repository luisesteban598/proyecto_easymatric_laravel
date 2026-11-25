<?php

namespace App\Http\Controllers;

use App\Models\Class_Groups;
use App\Models\Campuse;
use App\Models\Grade_level;
use App\Models\Academic_Year;
use Illuminate\Http\Request;

class ClassGroupsController extends Controller
{
    public function index()
    {
        $classGroups = Class_Groups::all();
        return response()->json($classGroups);
    }

    public function create()
    {
        $campuses = Campuse::all();
        $gradeLevels = Grade_level::all();
        $academicYears = Academic_Year::all();

        return view('class_groups.create', compact('campuses', 'gradeLevels', 'academicYears'));
    }

    public function store(Request $request)
    {
        $classGroups = Class_Groups::create($request->all());
        return response()->json($classGroups);
    }

    public function show($id)
    {
        $classGroups = Class_Groups::find($id);
        return response()->json($classGroups);
    }

    public function edit(Class_Groups $classGroups)
    {
        $campuses = Campuse::all();
        $gradeLevels = Grade_level::all();
        $academicYears = Academic_Year::all();

        return response()->json(compact('classGroups', 'campuses', 'gradeLevels', 'academicYears'));
    }

    public function update(Request $request, Class_Groups $classGroups)
    {
        $classGroups->update($request->all());
        return response()->json($classGroups);
    }

    public function destroy(Class_Groups $classGroups)
    {
        $classGroups->delete();
        return response()->json($classGroups);
    }
}