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
        Schema::create('class__groups', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('shift');
            $table->integer('capacity');

            // Sede en la que funciona el grupo académico.
            $table->unsignedBigInteger('campus_id')->nullable();
            $table->foreign('campus_id')
                ->references('id')
                ->on('campuses')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('grade_level_id')->nullable();
            $table->foreign('grade_level_id')
                ->references('id')
                ->on('grade_levels')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->foreign('academic_year_id')
                ->references('id')
                ->on('academic__years')
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
        Schema::dropIfExists('class__groups');
    }
};
