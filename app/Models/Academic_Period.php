<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_Period extends Model
{
    use HasFactory;

    public function academicYear(){
        return $this->belongsTo('App\Models\Academic_Year');
    }

    public function modules(){
        return $this->hasMany('App\Models\Module');
    }

    public function grades(){
        return $this->hasMany('App\Models\Grade');
    }

    protected $fillable = [
        'name',
        'slug',
        'start_on',
        'end_orden',
        'sort_orden',
        'academic__year_id'
    ];
}
