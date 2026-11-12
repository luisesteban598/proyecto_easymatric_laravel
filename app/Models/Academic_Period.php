<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'start_on',
        'end_orden',
        'sort_orden',
        'academic__year_id'
    ];
}
