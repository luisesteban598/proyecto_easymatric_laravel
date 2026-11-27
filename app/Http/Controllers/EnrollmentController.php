<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    //
    public function index()
    {
        $enrollments = Enrollment::all();

        return response()->json($enrollments);
    }

    public function store(Request $request)
    {
        $enrollments=Enrollment::create($request->all());
        //return redirect()->route('enrollments.index')->with('success', 'Matrícula registrada con éxito');
        return response()->json($enrollments);
    }

    public function show($id)
    {
        $enrollments = Enrollment::find($id);
        return response()->json($enrollments);
    }


    public function update(Request $request, Enrollment $enrollment)
    {
        // Método más sencillo sin necesidad de poner todo lo que pertenece a esa tabla
        $enrollment->update($request->all());

        return response()->json($enrollment);
    }

    // Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json($enrollment);
    }
}
