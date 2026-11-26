<?php

namespace App\Http\Controllers;

use App\Models\Institution_Document;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class InstitutionDocumentController extends Controller
{
    public function index()
    {
        $institution_documents = Institution_Document::all();
        return response()->json($institution_documents);
    }

    public function salida(Request $request)
    {
        $request->validate([
            'doc_type'       => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'institution_id' => 'nullable|integer|exists:institutions,id',
            'campuse_id'     => 'nullable|integer|exists:campuses,id',
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
                'folder' => 'institution_documents',
                'resource_type' => 'image',
            ]
        );

        $institution_document = Institution_Document::create([
            'doc_type' => $request->doc_type,
            'title' => $request->title,
            'institution_id' => $request->institution_id,
            'campuse_id' => $request->campuse_id,
            'file_url' => $resultado['secure_url'],
            'file_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Institution_Document creada correctamente',
            'data' => $institution_document,
        ], 201);
    }


    public function show($id)
    {

        $institution_documents = Institution_Document::find($id);
        return response()->json($institution_documents);
    }


    public function edit(Institution_Document $institution_documents)
    { //Encuentro el Curso

        return response()->json($institution_documents);
    }

    public function update(Request $request, Institution_Document $institution_documents)
    {
        //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $institution_documents->update($request->all());

        return response()->json($institution_documents);
    }
    //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Institution_Document $institution_documents)
    {
        $institution_documents->delete();
        return response()->json($institution_documents);
    }
}
