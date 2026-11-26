<?php

namespace App\Http\Controllers;

use App\Models\Enrollment_Document;
use App\Models\Enrollment;
use App\Models\Requirement_Type;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class EnrollmentDocumentController extends Controller
{
   public function index(){

        $enrollmentDocuments=Enrollment_Document::all();

        return response()->json($enrollmentDocuments);


    }

    
    public function store(Request $request){
       //si se le pone el  return Enrollment_Document::create($request->all()); muestra los datos escritos
       // $enrollmentDocuments = Enrollment_Document::create($request->all());
       // return response()->json($enrollmentDocuments);

       $request->validate([
            'status'              => 'required|string|max:255',
            'enrollment_id'       => 'nullable|integer|exists:enrollments,id',
            'requirement_type_id' => 'nullable|integer|exists:requirement__types,id',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $file = $request->file('imagen');
        $resultado = $this->uploadToCloudinary($file);

        $enrollmentDocument = Enrollment_Document::create([
            'status' => $request->status,
            'enrollment_id' => $request->enrollment_id,
            'requirement__type_id' => $request->requirement_type_id,
            'file_url' => $resultado['secure_url'],
            'file_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Enrollment_Document creada correctamente',
            'data' => $enrollmentDocument,
        ], 201);
    }

    private function uploadToCloudinary($file)
{
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
            'folder' => 'enrollmentDocuments',
            'resource_type' => 'auto', // o 'image' si solo subes imágenes
        ]
    );

    return method_exists($resultado, 'getArrayCopy')
        ? $resultado->getArrayCopy()
        : (array) $resultado;

    }


    public function show ($id){

    $enrollmentDocuments=Enrollment_Document::find($id);
    return response()->json($enrollmentDocuments);
    

    }
    
    public function update(Request $request, Enrollment_Document $enrollmentDocuments)
    {
    //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $enrollmentDocuments->update($request->all());

        return response()->json($enrollmentDocuments);
    }
      //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Enrollment_Document $enrollmentDocuments)
    {
        $enrollmentDocuments->delete();
        return response()->json($enrollmentDocuments);
    }
}