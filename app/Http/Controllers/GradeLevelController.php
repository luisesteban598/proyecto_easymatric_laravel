<?php

namespace App\Http\Controllers;

use App\Models\Grade_level;
use App\Models\Institution;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index()
    {
        $gradeLevels = Grade_level::all();
        return response()->json($gradeLevels);
    }


    public function store(Request $request)
    {
        $gradeLevels = Grade_level::create($request->all());
        return response()->json($gradeLevels);
    }

    public function show($id)
    {
        $gradeLevels = Grade_level::find($id);
        return response()->json($gradeLevels);
    }


    public function update(Request $request, Grade_level $gradeLevels)
    {
        $gradeLevels->update($request->all());
        return response()->json($gradeLevels);
    }

    public function destroy(Grade_level $gradeLevels)
    {
        $gradeLevels->delete();
        return response()->json($gradeLevels);
    }
}