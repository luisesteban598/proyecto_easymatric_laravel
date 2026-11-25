<?php

namespace App\Http\Controllers;

use App\Models\Requirement_Type;
use App\Models\Institution;
use Illuminate\Http\Request;

class RequirementTypeController extends Controller
{
    public function index()
    {
        $requirementTypes = Requirement_Type::all();
        return response()->json($requirementTypes);
    }


    public function store(Request $request)
    {
        $requirementTypes = Requirement_Type::create($request->all());
        return response()->json($requirementTypes);
    }

    public function show($id)
    {
        $requirementTypes = Requirement_Type::find($id);
        return response()->json($requirementTypes);
    }


    public function update(Request $request, Requirement_Type $requirementTypes)
    {
        $requirementTypes->update($request->all());
        return response()->json($requirementTypes);
    }

    public function destroy(Requirement_Type $requirementTypes)
    {
        $requirementTypes->delete();
        return response()->json($requirementTypes);
    }
}