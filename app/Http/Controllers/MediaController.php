<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    // Lista todos los archivos multimedia y muestra quién los subió.
    public function index()
    {
        $media = Media::with('uploadedBy')->get();

        return response()->json($media);
    }

    // Devuelve los campos aceptados por el endpoint de carga.
    public function create()
    {
        return response()->json([
            'message' => 'Upload a file with multipart/form-data',
            'fields' => [
                'file',
                'uploaded_by',
                'cloudinary_public_id',
                'folder',
            ],
        ]);
    }

    // Crea un registro desde un archivo local o desde una URL de Cloudinary.
    public function salida(Request $request)
    {
        $validated = $request->validate([
            'file' => ['nullable', 'file', 'max:10240'],
            'cloudinary_url' => ['nullable', 'url', 'max:2048'],
            'uploaded_by' => ['nullable', 'integer', 'exists:user_systems,id'],
            'cloudinary_public_id' => ['nullable', 'string', 'max:255', 'unique:media,cloudinary_public_id'],
            'folder' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:50'],
            'resource_type' => ['nullable', 'string', 'max:50'],
        ]);

        // Exige al menos una fuente válida antes de crear el registro.
        if (!$request->hasFile('file') && empty($validated['cloudinary_url'])) {
            return response()->json([
                'message' => 'Debe enviar un archivo o una cloudinary_url.',
            ], 422);
        }

        $url = $validated['cloudinary_url'] ?? null;
        $bytes = null;
        $width = null;
        $height = null;
        $format = $validated['format'] ?? null;
        $publicId = $validated['cloudinary_public_id'] ?? null;

        if ($request->hasFile('file')) {
            // Guarda el archivo localmente y extrae metadatos básicos.
            $file = $request->file('file');
            $path = $file->store('media', 'public');
            $url = Storage::disk('public')->url($path);
            $bytes = $file->getSize();
            $format = $format ?: $file->extension();
            $publicId = $publicId ?: 'media/' . Str::uuid();

            if (str_starts_with($file->getMimeType(), 'image/')) {
                // Obtiene el ancho y alto cuando el archivo es una imagen.
                $dimensions = @getimagesize($file->getRealPath());
                if ($dimensions) {
                    $width = $dimensions[0];
                    $height = $dimensions[1];
                }
            }
        }

        $media = Media::create([
            'uploaded_by' => $validated['uploaded_by'] ?? null,
            'cloudinary_public_id' => $publicId,
            'cloudinary_url' => $url,
            'folder' => $validated['folder'] ?? null,
            'format' => $format,
            'resource_type' => $validated['resource_type'] ?? ($request->hasFile('file') ? $request->file('file')->getMimeType() : null),
            'bytes' => $bytes,
            'width' => $width,
            'height' => $height,
        ]);

        return response()->json($media, 201);
    }

    // Busca un archivo multimedia específico.
    public function show($id)
    {
        $media = Media::with('uploadedBy')->findOrFail($id);

        return response()->json($media);
    }

    // Devuelve los datos actuales para preparar una edición.
    public function edit(Media $media)
    {
        return response()->json($media);
    }

    // Actualiza únicamente los datos validados del registro.
    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'uploaded_by' => ['nullable', 'integer', 'exists:user_systems,id'],
            'cloudinary_public_id' => ['nullable', 'string', 'max:255', 'unique:media,cloudinary_public_id,' . $media->id],
            'cloudinary_url' => ['required', 'url', 'max:2048'],
            'folder' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:50'],
            'resource_type' => ['nullable', 'string', 'max:50'],
            'bytes' => ['nullable', 'integer', 'min:0'],
            'width' => ['nullable', 'integer', 'min:0'],
            'height' => ['nullable', 'integer', 'min:0'],
        ]);

        $media->update($validated);

        return response()->json($media);
    }

    // Elimina el archivo local asociado y después elimina su registro.
    public function destroy(Media $media)
    {
        if ($media->cloudinary_public_id && str_starts_with($media->cloudinary_public_id, 'media/')) {
            $path = 'media/' . basename(parse_url($media->cloudinary_url, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $media->delete();

        return response()->json([
            'message' => 'Archivo multimedia eliminado correctamente.',
        ]);
    }
}
