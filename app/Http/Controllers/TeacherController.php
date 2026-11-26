<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Teacher;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    //
    public function profile(Request $request)
    {
        $user = $request->user();
        $role = Str::slug($user->rol?->slug ?? $user->rol?->name_role ?? '');
        abort_unless(in_array($role, ['teacher', 'docente', 'profesor', 'profesora'], true), 403);

        $teacher = $user->teacher()
            ->with([
                'userSystem:id,first_name,middle_name,last_name,second_last_name,document,phone,email,photo_url',
                'institution:id,name_institution,city',
            ])
            ->first();

        abort_unless($teacher, 403, 'La cuenta no tiene un perfil docente asociado.');

        return response()->json([
            'teacher' => [
                'id' => $teacher->id,
                'specialty' => $teacher->specialty,
                'user' => $teacher->userSystem,
                'institution' => $teacher->institution,
            ],
        ]);
    }

    public function index(){

        $teachers = Teacher::with(
            'userSystem:id,first_name,middle_name,last_name,second_last_name',
        )->get();

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
