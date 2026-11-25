<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement_Type extends Model
{
    use HasFactory;
    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function documents(){
        return $this->hasMany('App\Models\Enrollment_Document');
    }

    protected $fillable = [
        'name',
        'code',
        'is_required',
        'applies_to_cycle',
        'institution_id'
    ];
}
