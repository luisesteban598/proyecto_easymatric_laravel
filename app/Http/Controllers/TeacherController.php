<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Teacher;
use App\Models\UserSystem;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function index(){

        $teachers=Teacher::all();

        return response()->json($teachers);


    }


    public function salida(Request $request){
        $teachers=Teacher::create($request->all());
        //return redirect()->route('teachers.index')->with('success', 'Profesor registrado exitosamente');
        return response()->json($teachers);

    }

    public function show ($id){

        $teacher=Teacher::find($id);
        return response()->json($teacher);


    }



    public function update(Request $request, Teacher $teacher)
    {
        //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $teacher->update($request->all());

        return response()->json($teacher);
    }

    //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json($teacher);
    }
}
