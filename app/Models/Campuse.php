<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campuse extends Model
{
    use HasFactory;

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
