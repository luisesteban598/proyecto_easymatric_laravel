<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Module;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GradeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Grade::query();
        $user = $request->user();
        $role = $this->roleSlug($user);

        if (in_array($role, ['teacher', 'docente', 'profesor', 'profesora'], true)) {
            $teacherId = $user->teacher?->id;
            abort_unless($teacherId, 403, 'La cuenta no tiene un perfil docente asociado.');
            $query->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('teacher_id', $teacherId));
        } else {
            abort_unless(in_array($role, ['admin', 'administrador', 'administrator'], true), 403);
        }

        $grades = $query->get();

        return response()->json($grades);
    }

    public function salida(Request $request)
    {
        $this->authorizeModule($request->user(), $request->input('module_id'));
        $grades = Grade::create($request->all());

        return response()->json($grades);
    }

    public function show(Request $request, $id)
    {
        $grades = Grade::with('module')->findOrFail($id);
        $this->authorizeGrade($request->user(), $grades);

        return response()->json($grades);
    }

    public function update(Request $request, Grade $grade)
    {
        $this->authorizeGrade($request->user(), $grade);
        if ($request->filled('module_id')) {
            $this->authorizeModule($request->user(), $request->input('module_id'));
        }
        $grade->update($request->all());

        return response()->json($grade);
    }

    public function destroy(Request $request, Grade $grade)
    {
        $this->authorizeGrade($request->user(), $grade);
        $grade->delete();

        return response()->json($grade);
    }

    private function roleSlug(?UserSystem $user): string
    {
        return Str::slug($user?->rol?->slug ?? $user?->rol?->name_role ?? '');
    }

    private function authorizeModule(?UserSystem $user, $moduleId): void
    {
        if (in_array($this->roleSlug($user), ['admin', 'administrador', 'administrator'], true)) {
            return;
        }

        $teacherId = $user?->teacher?->id;
        abort_unless(
            $teacherId && Module::whereKey($moduleId)->where('teacher_id', $teacherId)->exists(),
            404,
        );
    }

    private function authorizeGrade(?UserSystem $user, Grade $grade): void
    {
        $this->authorizeModule($user, $grade->module_id);
    }
}
