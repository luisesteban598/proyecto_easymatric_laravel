<?php

namespace App\Http\Controllers;

use App\Models\Campuse;
use App\Models\Institution;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class CampuseController extends Controller
{
    public function index(){

        $campuses=Campuse::all();

        return response()->json($campuses);
    }
    
    public function salida(Request $request){
       //si se le pone el  return Campuse::create($request->all()); muestra los datos escritos
       // $campuses = Campuse::create($request->all());
       // return response()->json($campuses);

       $request->validate([
            'name'           => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'phone'          => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'is_main'        => 'sometimes|boolean',
            'institution_id' => 'nullable|integer|exists:institutions,id',
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
                'folder' => 'campuses',
                'resource_type' => 'image',
            ]
        );

        $campuse = Campuse::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_main' => $request->is_main,
            'institution_id' => $request->institution_id,
            'facade_url' => $resultado['secure_url'],
            'facade_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Campuse creada correctamente',
            'data' => $campuse,
        ], 201);
        
    }


    public function show ($id){

     $campuses=Campuse::find($id);
    return response()->json($campuses);
    

    }

    
    public function edit(Campuse $campuses)
    { //Encuentro el Curso

        return response()->json($campuses);
    }

     public function update(Request $request, Campuse $campuses)
    {
    //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $campuses->update($request->all());

        return response()->json($campuses);
    }
      //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Campuse $campuses)
    {
        $campuses->delete();
        return response()->json($campuses);
    }
}
