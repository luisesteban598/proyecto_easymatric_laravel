<?php

namespace App\Http\Controllers;

use App\Models\Grade_Subject;
use App\Models\Grade_level;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeSubjectController extends Controller
{
    public function index()
    {
        $gradeSubjects = Grade_Subject::all();
        return response()->json($gradeSubjects);
    }


    public function store(Request $request)
    {
        $gradeSubjects = Grade_Subject::create($request->all());
        return response()->json($gradeSubjects);
    }

    public function show($id)
    {
        $gradeSubjects = Grade_Subject::find($id);
        return response()->json($gradeSubjects);
    }


    public function update(Request $request, Grade_Subject $gradeSubjects)
    {
        $gradeSubjects->update($request->all());
        return response()->json($gradeSubjects);
    }

    public function destroy(Grade_Subject $gradeSubjects)
    {
        $gradeSubjects->delete();
        return response()->json($gradeSubjects);
    }
}