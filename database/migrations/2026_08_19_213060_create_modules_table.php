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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name_module');
            $table->string('description_module');
            $table->string('schedule');
            $table->string('duration');
            $table->integer('seats');
            $table->integer('weekly_hours');
            $table->date('enrollment_opens_at');
            $table->date('enrollment_closes_at');
            $table->boolean('allow_self_enrollment');
            $table->boolean('is_published');

            $table->unsignedBigInteger('class_group_id')->nullable();
            $table->foreign('class_group_id')
                ->references('id')
                ->on('class__groups')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('academic_period_id')->nullable();
            $table->foreign('academic_period_id')
                ->references('id')
                ->on('academic__periods')
                ->onDelete('set null')
                ->onUpdate('set null');    

            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('set null')
                ->onUpdate('set null');
            $table->timestamps();
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });

        Schema::dropIfExists('modules');
    }
};
