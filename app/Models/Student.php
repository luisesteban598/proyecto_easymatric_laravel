<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function userSystem(){
        return $this->belongsTo('App\Models\UserSystem');
    }

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function guardian(){
        return $this->belongsTo('App\Models\Guardian');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }

    public function grades(){
        return $this->hasMany('App\Models\Grade');
    }


    public function gradeLevel(){
        return $this->belongsTo('App\Models\Grade_level');
    }

    public function classGroup(){
        return $this->belongsTo('App\Models\Class_Groups');
    }

    public function guardians(){
        return $this->belongsToMany('App\Models\Guardian');
    }

    public function modules(){
        return $this->belongsToMany('App\Models\Module');
    }

    protected $fillable = [
        'birth_date',
        'gender',
        'address',
        'socieconomic_stratum',
        'grade_level_id',
        'class_group_id',
        'user_system_id',
        'guardian_id',
        'institution_id',
       
    ];
}
