<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $subjects=Subject::create($request->all());
        return response()->json($subjects);
    }

    public function show($id)
    {
        $subjects = Subject::find($id);
        return response()->json($subjects);
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->all());
        return response()->json($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json($subject);
    }
}
