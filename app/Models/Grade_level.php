<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade_level extends Model
{
    use HasFactory;

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Subject');
    }

    public function students(){
        return $this->hasMany('App\Models\Student');
    }

    public function classGroups(){
        return $this->hasMany('App\Models\Class_Groups');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }

    protected $fillable = [
        'name',
        'cycle',
        'sort_order',
        'institution_id'
    ];
}
