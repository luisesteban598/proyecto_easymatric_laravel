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
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();

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

            // Módulo al que se postula el estudiante.
            $table->unsignedBigInteger('module_id')->nullable();
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('set null')
                ->onUpdate('cascade');

            // Requisitos asociados al proceso de matrícula.
            $table->unsignedBigInteger('requirement_id')->nullable();
            $table->foreign('requirement_id')
                ->references('id')
                ->on('requirements')
                ->onDelete('set null')
                ->onUpdate('cascade');

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