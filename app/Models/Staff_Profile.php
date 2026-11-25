<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_Profile extends Model
{
    use HasFactory;

    public function userSystem(){
        return $this->belongsTo('App\Models\UserSystem');
    }

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    protected $fillable = [
        'job_title',
        'office_phone',
        'user_system_id',
        'institution_id'
    ];
}
