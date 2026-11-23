<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // Usuario del sistema que realizó la carga.
    public function uploadedBy()
    {
        return $this->belongsTo('App\Models\UserSystem', 'uploaded_by');
    }

    // Campos que pueden asignarse de forma masiva al crear o actualizar media.
    protected $fillable = [
        'uploaded_by',
        'cloudinary_public_id',
        'cloudinary_url',
        'folder',
        'format',
        'resource_type',
        'bytes',
        'width',
        'height',
    ];
}
