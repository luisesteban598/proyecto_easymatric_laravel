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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            // Usuario que realizó la carga.
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('user_systems')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->string('cloudinary_public_id')->unique()->nullable();
            $table->string('cloudinary_url');
            $table->string('folder')->nullable();
            $table->string('format')->nullable();
            $table->string('resource_type')->nullable();
            $table->unsignedBigInteger('bytes')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
