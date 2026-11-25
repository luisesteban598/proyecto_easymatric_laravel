<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Comprueba si una columna de una tabla tiene una clave foránea activa.
    private function hasForeignKey(string $table, string $column): bool
    {
        $database = DB::getDatabaseName();
        $foreignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('COLUMN_NAME', $column)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->exists();

        return $foreignKey;
    }

    public function up(): void
    {
        // Normaliza el nombre de la sede en grupos académicos.
        if (Schema::hasTable('class__groups') && Schema::hasColumn('class__groups', 'campuse_id')) {
            if ($this->hasForeignKey('class__groups', 'campuse_id')) {
                Schema::table('class__groups', function (Blueprint $table) {
                    $table->dropForeign(['campuse_id']);
                });
            }
            Schema::table('class__groups', function (Blueprint $table) {
                DB::statement('ALTER TABLE `class__groups` CHANGE COLUMN `campuse_id` `campus_id` BIGINT UNSIGNED NULL');
            });
            Schema::table('class__groups', function (Blueprint $table) {
                $table->foreign('campus_id')
                    ->references('id')
                    ->on('campuses')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            });
        }

        // Normaliza el identificador del año académico en periodos.
        if (Schema::hasTable('academic__periods') && Schema::hasColumn('academic__periods', 'academic__year_id')) {
            if ($this->hasForeignKey('academic__periods', 'academic__year_id')) {
                Schema::table('academic__periods', function (Blueprint $table) {
                    $table->dropForeign(['academic__year_id']);
                });
            }
            Schema::table('academic__periods', function (Blueprint $table) {
                DB::statement('ALTER TABLE `academic__periods` CHANGE COLUMN `academic__year_id` `academic_year_id` BIGINT UNSIGNED NULL');
            });
            Schema::table('academic__periods', function (Blueprint $table) {
                $table->foreign('academic_year_id')
                    ->references('id')
                    ->on('academic__years')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            });
        }

        // Normaliza el identificador de institución asociado a materias.
        if (Schema::hasTable('subjects') && Schema::hasColumn('subjects', 'institucion_id')) {
            if ($this->hasForeignKey('subjects', 'institucion_id')) {
                Schema::table('subjects', function (Blueprint $table) {
                    $table->dropForeign(['institucion_id']);
                });
            }
            Schema::table('subjects', function (Blueprint $table) {
                DB::statement('ALTER TABLE `subjects` CHANGE COLUMN `institucion_id` `institution_id` BIGINT UNSIGNED NULL');
            });
            Schema::table('subjects', function (Blueprint $table) {
                $table->foreign('institution_id')
                    ->references('id')
                    ->on('institutions')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            });
        }

        // Normaliza el identificador de sede en documentos institucionales.
        if (Schema::hasTable('institution__documents') && Schema::hasColumn('institution__documents', 'campuse_id')) {
            if ($this->hasForeignKey('institution__documents', 'campuse_id')) {
                Schema::table('institution__documents', function (Blueprint $table) {
                    $table->dropForeign(['campuse_id']);
                });
            }
            Schema::table('institution__documents', function (Blueprint $table) {
                DB::statement('ALTER TABLE `institution__documents` CHANGE COLUMN `campuse_id` `campus_id` BIGINT UNSIGNED NULL');
            });
            Schema::table('institution__documents', function (Blueprint $table) {
                $table->foreign('campus_id')
                    ->references('id')
                    ->on('campuses')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            });
        }

        // Hace opcionales los datos de revisión y completa las relaciones de matrícula.
        if (Schema::hasTable('enrollments')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->timestamp('reviewed_at')->nullable()->change();
                $table->text('rejection_reason')->nullable()->change();

                if (!Schema::hasColumn('enrollments', 'module_id')) {
                    $table->unsignedBigInteger('module_id')->nullable()->after('student_id');
                }
                if (!Schema::hasColumn('enrollments', 'requirement_id')) {
                    $table->unsignedBigInteger('requirement_id')->nullable()->after('module_id');
                }
            });

            if (Schema::hasColumn('enrollments', 'module_id')) {
                Schema::table('enrollments', function (Blueprint $table) {
                    $table->foreign('module_id')
                        ->references('id')
                        ->on('modules')
                        ->onDelete('set null')
                        ->onUpdate('cascade');
                });
            }

            if (Schema::hasColumn('enrollments', 'requirement_id')) {
                Schema::table('enrollments', function (Blueprint $table) {
                    $table->foreign('requirement_id')
                        ->references('id')
                        ->on('requirements')
                        ->onDelete('set null')
                        ->onUpdate('cascade');
                });
            }
        }

        // Vincula el programa académico con el temario multimedia.
        if (Schema::hasTable('modules')) {
            if (!Schema::hasColumn('modules', 'syllabus_media_id')) {
                Schema::table('modules', function (Blueprint $table) {
                    $table->unsignedBigInteger('syllabus_media_id')->nullable()->after('is_published');
                });
            }

            Schema::table('modules', function (Blueprint $table) {
                $table->foreign('syllabus_media_id')
                    ->references('id')
                    ->on('media')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }

        // Evita duplicar la misma materia dentro de un grado.
        if (Schema::hasTable('grade__subjects')) {
            Schema::table('grade__subjects', function (Blueprint $table) {
                $table->unique(['grade_level_id', 'subject_id']);
            });
        }

        // Evita duplicar relaciones estudiante-acudiente.
        if (Schema::hasTable('student__guardians')) {
            Schema::table('student__guardians', function (Blueprint $table) {
                $table->unique(['student_id', 'guardian_id']);
            });
        }

        // Evita inscribir dos veces al mismo estudiante en el mismo módulo.
        if (Schema::hasTable('module__enrollments')) {
            Schema::table('module__enrollments', function (Blueprint $table) {
                $table->unique(['module_id', 'student_id']);
            });
        }
    }

    // Revierte restricciones y columnas agregadas por esta migración.
    public function down(): void
    {
        if (Schema::hasTable('module__enrollments')) {
            Schema::table('module__enrollments', function (Blueprint $table) {
                $table->dropUnique(['module_id', 'student_id']);
            });
        }

        if (Schema::hasTable('student__guardians')) {
            Schema::table('student__guardians', function (Blueprint $table) {
                $table->dropUnique(['student_id', 'guardian_id']);
            });
        }

        if (Schema::hasTable('grade__subjects')) {
            Schema::table('grade__subjects', function (Blueprint $table) {
                $table->dropUnique(['grade_level_id', 'subject_id']);
            });
        }

        if (Schema::hasTable('modules') && Schema::hasColumn('modules', 'syllabus_media_id')) {
            Schema::table('modules', function (Blueprint $table) {
                $table->dropForeign(['syllabus_media_id']);
                $table->dropColumn('syllabus_media_id');
            });
        }

        if (Schema::hasTable('enrollments')) {
            if (Schema::hasColumn('enrollments', 'requirement_id')) {
                Schema::table('enrollments', function (Blueprint $table) {
                    $table->dropForeign(['requirement_id']);
                    $table->dropColumn('requirement_id');
                });
            }
            if (Schema::hasColumn('enrollments', 'module_id')) {
                Schema::table('enrollments', function (Blueprint $table) {
                    $table->dropForeign(['module_id']);
                    $table->dropColumn('module_id');
                });
            }
        }
    }
};
