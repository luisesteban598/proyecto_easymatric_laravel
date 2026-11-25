<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_Year extends Model
{
    use HasFactory;

     public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function periods(){
        return $this->hasMany('App\Models\Academic_Period');
    }

    public function classGroups(){
        return $this->hasMany('App\Models\Class_Groups');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }

    protected $fillable = [
        'name',
        'starts_on',
        'ends_on',
        'is_current',
        'institution_id'
    ];
}
