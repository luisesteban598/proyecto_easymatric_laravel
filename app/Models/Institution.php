<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    //comentario

    public function teachers(){
        return $this->hasMany('App\Models\Teacher');
    }
    //comentario de luis
    public function students(){
        return $this->hasMany('App\Models\Student');
    }

    public function userSystems(){
        return $this->hasMany('App\Models\UserSystem');
    }

    public function campuses(){
        return $this->hasMany('App\Models\Campuse');
    }

    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }

    public function gradeLevels(){
        return $this->hasMany('App\Models\Grade_level');
    }

    public function academicYears(){
        return $this->hasMany('App\Models\Academic_Year');
    }

    public function staffProfiles(){
        return $this->hasMany('App\Models\Staff_Profile');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Enrollment');
    }

    public function requirementTypes(){
        return $this->hasMany('App\Models\Requirement_Type');
    }

    

    protected $fillable = [
        'name_institution',
        'email_institution',
        'phone_institution',
        'address_institution',
        'description_institution',
       
    ];
}
