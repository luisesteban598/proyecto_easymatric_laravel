<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade_level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cycle',
        'sort_order',
        'institution_id'
    ];
}
