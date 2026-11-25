<?php

namespace App\Http\Controllers;

use App\Models\Student_Guardian;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;

class StudentGuardianController extends Controller
{
    public function index()
    {
        $studentGuardians = Student_Guardian::all();
        return response()->json($studentGuardians);
    }

    public function store(Request $request)
    {
        $studentGuardians = Student_Guardian::create($request->all());
        return response()->json($studentGuardians);
    }

    public function show($id)
    {
        $studentGuardians = Student_Guardian::find($id);
        return response()->json($studentGuardians);
    }

    public function update(Request $request, Student_Guardian $studentGuardians)
    {
        $studentGuardians->update($request->all());
        return response()->json($studentGuardians);
    }

    public function destroy(Student_Guardian $studentGuardians)
    {
        $studentGuardians->delete();
        return response()->json($studentGuardians);
    }
}