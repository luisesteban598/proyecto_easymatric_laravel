<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class ModuleController extends Controller
{
    //
    public function index()
    {

        $modules = Module::all();

        return response()->json($modules);
    }

    public function salida(Request $request)
    {
        //si se le pone el  return Module::create($request->all()); muestra los datos escritos
        // $modules = Module::create($request->all());
        // return response()->json($modules);

        $request->validate([
            'name_module'           => 'required|string|max:255',
            'description_module'    => 'required|string|max:255',
            'schedule'              => 'required|string|max:255',
            'duration'              => 'required|string|max:255',
            'seats'                 => 'required|integer|min:0',
            'weekly_hours'          => 'required|integer|min:0',
            'enrollment_opens_at'   => 'required|date',
            'enrollment_closes_at'  => 'required|date|after_or_equal:enrollment_opens_at',
            'allow_self_enrollment' => 'required|boolean',
            'is_published'          => 'required|boolean',
            'teacher_id'            => 'nullable|integer|exists:teachers,id',
            'subject_id'            => 'nullable|integer|exists:subjects,id',
            'class_group_id'        => 'nullable|integer|exists:class__groups,id',
            'academic__period_id'   => 'nullable|integer|exists:academic__periods,id',
            'imagen'         => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $file = $request->file('imagen');

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);

        $resultado = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'modules',
                'resource_type' => 'image',
            ]
        );

        $module = Module::create([
            'name_module' => $request->name_module,
            'description_module' => $request->description_module,
            'schedule' => $request->schedule,
            'duration' => $request->duration,
            'seats' => $request->seats,
            'weekly_hours' => $request->weekly_hours,
            'enrollment_opens_at' => $request->enrollment_opens_at,
            'enrollment_closes_at' => $request->enrollment_closes_at,
            'allow_self_enrollment' => $request->allow_self_enrollment,
            'is_published' => $request->is_published,
            'teacher_id' => $request->teacher_id,
            'subject_id' => $request->subject_id,
            'class_group_id' => $request->class_group_id,
            'academic__period_id' => $request->academic__period_id,
            'file_url' => $resultado['secure_url'],
            'file_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Module creada correctamente',
            'data' => $module,
        ], 201);
    }


    public function show($id)
    {

        $modules = Module::find($id);
        return response()->json($modules);
    }


    public function edit(Module $modules)
    { //Encuentro el Curso

        return response()->json($modules);
    }

    public function update(Request $request, Module $modules)
    {
        //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $modules->update($request->all());

        return response()->json($modules);
    }
    //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Module $modules)
    {
        $modules->delete();
        return response()->json($modules);
    }
}
