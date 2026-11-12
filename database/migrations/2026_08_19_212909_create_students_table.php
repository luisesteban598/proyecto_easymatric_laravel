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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date');
            $table->string('gender');
            $table->string('address');
            $table->integer('socieconomic_stratum');

            $table->unsignedBigInteger('grade_level_id')->nullable();
            $table->foreign('grade_level_id')
                ->references('id')
                ->on('grade_levels')
                ->onDelete('set null')
                ->onUpdate('set null');

                $table->unsignedBigInteger('class_group_id')->nullable();
            $table->foreign('class_group_id')
                ->references('id')
                ->on('class__groups')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('user_system_id')->nullable();
            $table->foreign('user_system_id')
                ->references('id')
                ->on('user_systems')
                ->onDelete('set null')
                ->onUpdate('set null');
                
            $table->unsignedBigInteger('guardian_id')->nullable();
            $table->foreign('guardian_id')
                ->references('id')
                ->on('guardians')
                ->onDelete('set null')
                ->onUpdate('set null');
            
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
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
        Schema::dropIfExists('students');
    }
};
