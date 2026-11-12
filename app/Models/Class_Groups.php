<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Class_Groups extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'shift',
        'capacity',
        'campuse_id',
        'grade_level_id',
        'academic_year_id'
    ];
}
