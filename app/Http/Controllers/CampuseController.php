<?php

namespace App\Http\Controllers;

use App\Models\Campuse;
use App\Models\Institution;
use Illuminate\Http\Request;

class CampuseController extends Controller
{
    public function index()
    {
        $campuses = Campuse::all();
        return response()->json($campuses);
    }

    public function create()
    {
        $institutions = Institution::all();
        return view('campuses.create', compact('institutions'));
    }

    public function store(Request $request)
    {
        $campuses = Campuse::create($request->all());
        return response()->json($campuses);
    }

    public function show($id)
    {
        $campuses = Campuse::find($id);
        return response()->json($campuses);
    }

    public function edit(Campuse $campuses)
    {
        $institutions = Institution::all();
        return response()->json(compact('campuses', 'institutions'));
    }

    public function update(Request $request, Campuse $campuses)
    {
        $campuses->update($request->all());
        return response()->json($campuses);
    }

    public function destroy(Campuse $campuses)
    {
        $campuses->delete();
        return response()->json($campuses);
    }
}
