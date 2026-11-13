<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSystem extends Model
{
    use HasFactory;

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function teacher(){
        return $this->hasOne('App\Models\Teacher');
    }

    public function student(){
        return $this->hasOne('App\Models\Student');
    }

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function staffProfile(){
        return $this->hasOne('App\Models\Staff_Profile');
    }

    public function contactMessages(){
        return $this->hasMany('App\Models\Contact_Message');
    }

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'document',
        'phone',
        'email',
        'password',
        'document_type',
        'username',
        'status',   
        'institution_id',
        'rol_id', 
    ];
}
 