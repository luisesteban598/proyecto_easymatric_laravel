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
        Schema::create('institution__documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_type');
            $table->string('title');

            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->unsignedBigInteger('campuse_id')->nullable();
            $table->foreign('campuse_id')
                ->references('id')
                ->on('campuses')
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
        Schema::dropIfExists('institution__documents');
    }
};
