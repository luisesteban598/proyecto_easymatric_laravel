<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module_Enrollment extends Model
{
    use HasFactory;


    protected $fillable = [
        'satus',
        'module_id',
        'student_id',
    ];
}
