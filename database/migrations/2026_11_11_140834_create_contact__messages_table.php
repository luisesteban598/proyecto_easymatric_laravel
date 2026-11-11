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
        Schema::create('contact__messages', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->string('body');
            $table->string('status')->default('pending');

            $table->unsignedBigInteger('user_system_id')->nullable();
            $table->foreign('user_system_id')
                ->references('id')
                ->on('user_systems')
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
        Schema::dropIfExists('contact__messages');
    }
};
