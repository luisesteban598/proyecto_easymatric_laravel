<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'office_phone',
        'user_system_id',
        'institution_id'
    ];
}
