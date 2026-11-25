<?php

namespace App\Http\Controllers;

use App\Models\Enrollment_Document;
use App\Models\Enrollment;
use App\Models\Requirement_Type;
use Illuminate\Http\Request;

class EnrollmentDocumentController extends Controller
{
    public function index()
    {
        $enrollmentDocuments = Enrollment_Document::all();
        return response()->json($enrollmentDocuments);
    }

    public function create()
    {
        $enrollments = Enrollment::all();
        $requirementTypes = Requirement_Type::all();

        return view('enrollment_documents.create', compact('enrollments', 'requirementTypes'));
    }

    public function store(Request $request)
    {
        $enrollmentDocuments = Enrollment_Document::create($request->all());
        return response()->json($enrollmentDocuments);
    }

    public function show($id)
    {
        $enrollmentDocuments = Enrollment_Document::find($id);
        return response()->json($enrollmentDocuments);
    }

    public function edit(Enrollment_Document $enrollmentDocuments)
    {
        $enrollments = Enrollment::all();
        $requirementTypes = Requirement_Type::all();

        return response()->json(compact('enrollmentDocuments', 'enrollments', 'requirementTypes'));
    }

    public function update(Request $request, Enrollment_Document $enrollmentDocuments)
    {
        $enrollmentDocuments->update($request->all());
        return response()->json($enrollmentDocuments);
    }

    public function destroy(Enrollment_Document $enrollmentDocuments)
    {
        $enrollmentDocuments->delete();
        return response()->json($enrollmentDocuments);
    }
}