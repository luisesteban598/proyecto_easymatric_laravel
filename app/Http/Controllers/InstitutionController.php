<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(){
        $institutions = Institution::all();
        return response()->json($institutions);
    }

    public function store(Request $request){
        $institutions = Institution::create($request->all());
        return response()->json($institutions);
    }

    public function show ($id){

        $institutions = Institution::findOrFail($id);
        return response()->json($institutions);
        
    }

    public function update(Request $request, Institution $institution){
        $institution->update($request->all());
        return response()->json($institution);
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();
        return $institution;
    }
}
