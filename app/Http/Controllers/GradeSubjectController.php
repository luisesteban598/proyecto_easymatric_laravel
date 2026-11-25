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

    public function create()
    {
        $gradeLevels = Grade_level::all();
        $subjects = Subject::all();

        return view('grade_subjects.create', compact('gradeLevels', 'subjects'));
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

    public function edit(Grade_Subject $gradeSubjects)
    {
        $gradeLevels = Grade_level::all();
        $subjects = Subject::all();

        return response()->json(compact('gradeSubjects', 'gradeLevels', 'subjects'));
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