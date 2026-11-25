<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_Message extends Model
{
    use HasFactory;
    
    public function userSystem(){
        return $this->belongsTo('App\Models\UserSystem');
    }


    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'subject',
        'body',
        'status',
        'user_system_id'
    ];
}
