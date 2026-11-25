<?php

namespace App\Http\Controllers;

use App\Models\Module_Enrollment;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class ModuleEnrollmentController extends Controller
{
    public function index()
    {
        $moduleEnrollments = Module_Enrollment::all();
        return response()->json($moduleEnrollments);
    }



    public function store(Request $request)
    {
        $moduleEnrollments = Module_Enrollment::create($request->all());
        return response()->json($moduleEnrollments);
    }

    public function show($id)
    {
        $moduleEnrollments = Module_Enrollment::find($id);
        return response()->json($moduleEnrollments);
    }


    public function update(Request $request, Module_Enrollment $moduleEnrollments)
    {
        $moduleEnrollments->update($request->all());
        return response()->json($moduleEnrollments);
    }

    public function destroy(Module_Enrollment $moduleEnrollments)
    {
        $moduleEnrollments->delete();
        return response()->json($moduleEnrollments);
    }
}