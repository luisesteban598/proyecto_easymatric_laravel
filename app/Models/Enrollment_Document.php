<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment_Document extends Model
{
    use HasFactory;

    protected $table = 'enrollment__documents';

    protected $fillable = [
        'status',
        'enrollment_id',
        'requirement__type_id',
        'file_url',
        'file_public_id',
    ];
}
