<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module_Enrollment extends Model
{
    use HasFactory;

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    protected $fillable = [
        'status',
        'module_id',
        'student_id',
    ];
}
