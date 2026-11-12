<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'starts_on',
        'ends_on',
        'is_current',
        'institution_id'
    ];
}
