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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->decimal('grade');
            $table->string('evaluation_type');
            $table->date('registration_date');
            $table->decimal('recovery_grade');

            $table->unsignedBigInteger('module_id')->nullable();
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('academic_period_id')->nullable();
            $table->foreign('academic_period_id')
                ->references('id')
                ->on('academic__periods')
                ->onDelete('set null')
                ->onUpdate('set null');      

            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
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
        Schema::dropIfExists('grades');
    }
};
