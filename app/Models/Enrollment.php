<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function module(){
        return $this->belongsTo('App\Models\Module');
    }

    public function requirement(){
        return $this->belongsTo('App\Models\Requirement');
    }

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function campus(){
        return $this->belongsTo('App\Models\Campuse');
    }

    public function academicYear(){
        return $this->belongsTo('App\Models\Academic_Year');
    }

    public function gradeLevel(){
        return $this->belongsTo('App\Models\Grade_level');
    }


    protected $fillable = [
        'enrollment_date',
        'status',
        'enrollment_code',
        'shift',
        'reviewed_at',
        'rejection_reason',
        'institution_id',
        'campus_id',
        'academic_year_id',
        'grade_level_id',
        'student_id',
    ];
}
