<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution_Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_type',
        'title',
        'institution_id',
        'campus_id',
    ];
}
