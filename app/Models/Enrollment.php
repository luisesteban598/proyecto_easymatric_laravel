<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Enrollment extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Enrollment $enrollment): void {
            if (blank($enrollment->enrollment_code)) {
                do {
                    $enrollmentCode = 'MAT-' . now()->format('Y') . '-' . Str::upper(Str::random(8));
                } while (static::where('enrollment_code', $enrollmentCode)->exists());

                $enrollment->enrollment_code = $enrollmentCode;
            }
        });
    }

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function module(){
        return $this->belongsTo('App\Models\Module');
    }

    public function requirement(){
        return $this->belongsTo('App\Models\Requirement');
    }

    public function institution(){
        return $this->belongsTo('App\Models\Institution');
    }

    public function campus(){
        return $this->belongsTo('App\Models\Campuse');
    }

    public function academicYear(){
        return $this->belongsTo('App\Models\Academic_Year');
    }

    public function gradeLevel(){
        return $this->belongsTo('App\Models\Grade_level');
    }


    protected $fillable = [
        'enrollment_date',
        'status',
        'enrollment_code',
        'shift',
        'reviewed_at',
        'rejection_reason',
        'student_id',
        'institution_id',
        'campuse_id',
        'academic__year_id',
        'grade_level_id',
    ];
}
