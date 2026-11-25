<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //
    public function index()
    {
        $subjects = Subject::all();

        return response()->json($subjects);
    }


    public function salida(Request $request)
    {
        $subjects=Subject::create($request->all());
        //return redirect()->route('subjects.index')->with('success', 'Asignatura registrada exitosamente');
        return response()->json($subjects);
    }

    public function show($id)
    {
        $subjects = Subject::find($id);

        return response()->json($subjects);
    }


    public function update(Request $request, Subject $subjects)
    {
        // Método más sencillo sin necesidad de poner todo lo que pertenece a esa tabla
        $subjects->update($request->all());

        return response()->json($subjects);
    }

    // Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Subject $subjects)
    {
        $subjects->delete();

        return response()->json($subjects);
    }
}
