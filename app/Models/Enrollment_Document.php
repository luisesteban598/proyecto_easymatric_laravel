<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment_Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'enrollment_id',
        'requirement_type_id',
    ];
}
