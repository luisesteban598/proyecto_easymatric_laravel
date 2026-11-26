<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Institution;
use App\Models\Student;
use App\Models\UserSystem;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::with(['userSystem', 'guardian', 'institution'])->get();
        return response()->json($students);
    }


    public function salida(Request $request)
    {
        $students=Student::create($request->all());
       //return redirect()->route('students.index')->with('success', 'Estudiante registrado exitosamente');
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

        $query = Student::query()->where('document', $data['document']);

        $documentType = $data['document_type'] ?? null;
        if ($documentType !== null && trim($documentType) !== '') {
            $query->where('document_type', trim($documentType));
        }

        $student = $query->first();

        if (!$student) {
            return response()->json([
                'message' => 'No se encontró un estudiante con el documento indicado.',
            ], 404);
        }

        return response()->json(['data' => $student]);
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
