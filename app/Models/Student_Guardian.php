<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'relationship',
        'is_primary',
        'student_id',
        'guardian_id'
    ];
}
