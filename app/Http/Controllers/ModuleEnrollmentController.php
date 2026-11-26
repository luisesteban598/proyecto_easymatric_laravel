<?php

namespace App\Http\Controllers;

use App\Models\Module_Enrollment;
use App\Models\Module;
use App\Models\Student;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Module_Enrollment::query();
        $user = $request->user();
        $role = Str::slug($user->rol?->slug ?? $user->rol?->name_role ?? '');

        if (in_array($role, ['teacher', 'docente', 'profesor', 'profesora'], true)) {
            $teacherId = $this->teacherId($user);
            abort_unless($teacherId, 403, 'La cuenta no tiene un perfil docente asociado.');
            $query->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('teacher_id', $teacherId));
        }

        $moduleEnrollments = $query->get();
        return response()->json($moduleEnrollments);
    }



    public function store(Request $request)
    {
        abort_if($this->isTeacher($request->user()), 403, 'Los docentes no pueden crear inscripciones de estudiantes.');
        $moduleEnrollments = Module_Enrollment::create($request->all());
        return response()->json($moduleEnrollments);
    }

    public function show(Request $request, $id)
    {
        $moduleEnrollments = Module_Enrollment::with('module')->findOrFail($id);
        $this->authorizeEnrollmentAccess($request->user(), $moduleEnrollments);

        return response()->json($moduleEnrollments);
    }


    public function update(Request $request, Module_Enrollment $module_enrollment)
    {
        $this->authorizeEnrollmentAccess($request->user(), $module_enrollment);
        $module_enrollment->update($request->all());
        return response()->json($module_enrollment);
    }

    public function destroy(Request $request, Module_Enrollment $module_enrollment)
    {
        $this->authorizeEnrollmentAccess($request->user(), $module_enrollment);
        $module_enrollment->delete();
        return response()->json($module_enrollment);
    }

    private function isTeacher(?UserSystem $user): bool
    {
        $role = Str::slug($user?->rol?->slug ?? $user?->rol?->name_role ?? '');
        return in_array($role, ['teacher', 'docente', 'profesor', 'profesora'], true);
    }

    private function authorizeEnrollmentAccess(?UserSystem $user, Module_Enrollment $enrollment): void
    {
        if ($this->isTeacher($user)) {
            $teacherId = $this->teacherId($user);
            abort_unless(
                $teacherId && (int) $enrollment->module?->teacher_id === (int) $teacherId,
                404,
            );
            return;
        }

        $role = Str::slug($user?->rol?->slug ?? $user?->rol?->name_role ?? '');
        abort_unless(in_array($role, ['admin', 'administrador', 'administrator'], true), 403);
    }

    private function teacherId(?UserSystem $user): ?int
    {
        if (!$user) {
            return null;
        }

        $teacherId = $user->teacher()->value('id');
        return $teacherId ? (int) $teacherId : null;
    }
}