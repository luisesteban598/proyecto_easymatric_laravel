<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_systems', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('photo_url')->nullable()->change();
            $table->string('photo_public_id')->nullable()->change();
            $table->string('document_type')->nullable()->change();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('document')->nullable()->after('id');
            $table->string('document_type')->nullable()->after('document');
            $table->index(['document', 'document_type']);
            $table->date('birth_date')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->integer('socieconomic_stratum')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['document', 'document_type']);
            $table->dropColumn(['document', 'document_type']);
            $table->date('birth_date')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->integer('socieconomic_stratum')->nullable(false)->change();
        });

        Schema::table('user_systems', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->string('photo_url')->nullable(false)->change();
            $table->string('photo_public_id')->nullable(false)->change();
            $table->string('document_type')->nullable(false)->change();
        });
    }
};
