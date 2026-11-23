<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->date('enrollment_date');
            $table->string('status');
            $table->string('enrollment_code');
            $table->string('shift');
            $table->timestamp('reviewed_at');
            $table->text('rejection_reason');

            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('campus_id')->nullable();
            $table->foreign('campus_id')
                ->references('id')
                ->on('campuses')
                ->onDelete('set null')
                ->onUpdate('set null');  
                
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->foreign('academic_year_id')
                ->references('id')
                ->on('academic__years')
                ->onDelete('set null')
                ->onUpdate('set null');
                
            $table->unsignedBigInteger('grade_level_id')->nullable();
            $table->foreign('grade_level_id')
                ->references('id')
                ->on('grade_levels')
                ->onDelete('set null')
                ->onUpdate('set null');    

            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};