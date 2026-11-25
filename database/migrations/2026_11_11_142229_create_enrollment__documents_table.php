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
        Schema::create('enrollment__documents', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('file_url');
            $table->string('file_public_id');
            
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->foreign('enrollment_id')
                ->references('id')
                ->on('enrollments')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('requirement__type_id')->nullable();
            $table->foreign('requirement__type_id')
                ->references('id')
                ->on('requirement__types')
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
        Schema::dropIfExists('enrollment__documents');
    }
};
