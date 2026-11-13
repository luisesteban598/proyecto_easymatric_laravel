<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Class_Groups extends Model
{
    use HasFactory;

    public function campus(){
        return $this->belongsTo('App\Models\Campuse');
    }

    public function gradeLevel(){
        return $this->belongsTo('App\Models\Grade_level');
    }

    public function academicYear(){
        return $this->belongsTo('App\Models\Academic_Year');
    }

    public function students(){
        return $this->hasMany('App\Models\Student');
    }

    public function modules(){
        return $this->hasMany('App\Models\Module');
    }

    protected $fillable = [
        'section',
        'shift',
        'capacity',
        'campuse_id',
        'grade_level_id',
        'academic_year_id'
    ];
}
