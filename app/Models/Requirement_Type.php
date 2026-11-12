<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement_Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_required',
        'applies_to_cycle',
        'institution_id'
    ];
}
