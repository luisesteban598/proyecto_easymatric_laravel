<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campuse extends Model
{
    use HasFactory;

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function classGroups(){
        return $this->hasMany('App\Models\Class_Groups');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }


    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'is_main',
        'institution_id'
    ];
}
