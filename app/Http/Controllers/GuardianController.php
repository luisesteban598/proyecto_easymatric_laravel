<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    //
    public function index()
    {
        $guardians = Guardian::all();
        return response()->json($guardians);
    }

    public function store(Request $request)
    {
        $guardians = Guardian::create($request->all());
        return response()->json($guardians);
    }

    public function show($id)
    {
        $guardians = Guardian::find($id);
        return response()->json($guardians);
    }

    public function update(Request $request, Guardian $guardian)
    {
        $guardian->update($request->all());
        return response()->json($guardian);
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return response()->json($guardian);
    }
}
