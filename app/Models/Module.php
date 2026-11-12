<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }

    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }

    protected $fillable = [
        'name_module',
        'description_module',
        'schedule',
        'duration',
        'seats',
        'weekly_hours',
        'enrollment_opens_at',
        'enrollment_closes_at',
        'allow_self_enrollment',
        'is_published', 
        'class_group_id',
        'academic_period_id',
        'teacher_id',
       
    ];
}
