<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    public function module(){
        return $this->belongsTo('App\Models\Module');
    }

    public function academicPeriod(){
        return $this->belongsTo('App\Models\Academic_Period');
    }

    protected $fillable = [
        'grade',
        'evaluation_type',
        'registration_date',
        'recovery_grade',
        'module_id',
        'academic_period_id',
        'subject_id',
        'student_id',
      
    ];

}
