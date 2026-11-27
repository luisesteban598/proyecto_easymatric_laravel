<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::with(['userSystem', 'guardian', 'institution'])->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $students = Student::create($request->all());
        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function byDocument(Request $request)
    {
        $data = $request->validate([
            'document' => 'required|string|max:255',
            'document_type' => 'sometimes|nullable|string|max:255',
        ]);

        $document = trim($data['document']);
        $documentType = isset($data['document_type'])
            ? trim($data['document_type'])
            : null;

        $student = Student::query()
            ->select(['id', 'user_system_id'])
            ->whereHas('userSystem', function ($userQuery) use ($document, $documentType) {
                $userQuery->where('document', $document);

                if ($documentType !== null && $documentType !== '') {
                    $userQuery->where('document_type', $documentType);
                }
            })
            ->first();

        if (!$student) {
            return response()->json([
                'message' => 'No se encontró un estudiante con el documento indicado.',
            ], 404);
        }

        return response()->json([
            'data' => $student,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json($student);
    }
}
