<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Teacher;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($this->isTeacher($user)) {
            $teacher = $this->teacherFor($user);
            abort_unless($teacher, 403, 'La cuenta no tiene un perfil docente asociado.');

            return response()->json(
                Module::where('teacher_id', $teacher->id)->get(),
            );
        }

        return response()->json(Module::all());
    }

    public function salida(Request $request)
    {
        $user = $request->user();
        $isTeacher = $this->isTeacher($user);
        abort_unless($isTeacher || $this->isAdmin($user), 403, 'Solo docentes y administradores pueden crear módulos.');

        $teacher = $isTeacher ? $this->teacherFor($user) : null;
        if ($isTeacher) {
            abort_unless($teacher, 403, 'La cuenta no tiene un perfil docente asociado.');
        }

        $data = $request->validate([
            'name_module'           => 'required|string|max:255',
            'description_module'    => 'required|string|max:255',
            'schedule'              => 'required|string|max:255',
            'duration'              => 'required|string|max:255',
            'seats'                 => 'required|integer|min:0',
            'weekly_hours'          => 'required|integer|min:0',
            'enrollment_opens_at'   => 'required|date',
            'enrollment_closes_at'  => 'required|date|after_or_equal:enrollment_opens_at',
            'allow_self_enrollment' => 'required|boolean',
            'is_published'          => 'required|boolean',
            'teacher_id'            => $isTeacher
                ? 'nullable|integer|exists:teachers,id'
                : 'required|integer|exists:teachers,id',
            'subject_id'            => 'nullable|integer|exists:subjects,id',
            'class_group_id'        => 'nullable|integer|exists:class__groups,id',
            'academic__period_id'   => 'nullable|integer|exists:academic__periods,id',
            'syllabus'         => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        $data['allow_self_enrollment'] = $request->boolean('allow_self_enrollment');
        $data['is_published'] = $request->boolean('is_published');

        $file = $request->file('syllabus');

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);

        $resultado = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'modules',
                'resource_type' => 'image',
            ]
        );

        $module = Module::create([
            'name_module' => $request->name_module,
            'description_module' => $request->description_module,
            'schedule' => $request->schedule,
            'duration' => $request->duration,
            'seats' => $request->seats,
            'weekly_hours' => $request->weekly_hours,
            'enrollment_opens_at' => $request->enrollment_opens_at,
            'enrollment_closes_at' => $request->enrollment_closes_at,
            'allow_self_enrollment' => $data['allow_self_enrollment'],
            'is_published' => $data['is_published'],
            'teacher_id' => $isTeacher ? $teacher->id : $data['teacher_id'],
            'subject_id' => $request->subject_id,
            'class_group_id' => $request->class_group_id,
            'academic__period_id' => $request->academic__period_id,
            'syllabus_url' => $resultado['secure_url'],
            'syllabus_public_id' => $resultado['public_id'],
        ]);

        return response()->json([
            'message' => 'Module creada correctamente',
            'data' => $module,
        ], 201);
    }


    public function show(Request $request, $id)
    {
        $user = $request->user();
        if ($this->isTeacher($user)) {
            $teacher = $this->teacherFor($user);
            abort_unless($teacher, 403, 'La cuenta no tiene un perfil docente asociado.');

            return response()->json(
                Module::where('teacher_id', $teacher->id)->findOrFail($id),
            );
        }

        return response()->json(Module::findOrFail($id));
    }


    public function edit(Request $request, Module $modules)
    {
        $this->authorizeManagement($request->user(), $modules);

        return response()->json($modules);
    }

    public function update(Request $request, Module $module)
    {
        $user = $request->user();
        $this->authorizeManagement($user, $module);
        $isAdmin = $this->isAdmin($user);
        $data = $request->validate([
            'name_module' => 'sometimes|required|string|max:255',
            'description_module' => 'sometimes|required|string|max:255',
            'schedule' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|string|max:255',
            'seats' => 'sometimes|required|integer|min:0',
            'weekly_hours' => 'sometimes|required|integer|min:0',
            'enrollment_opens_at' => 'sometimes|required|date',
            'enrollment_closes_at' => 'sometimes|required|date',
            'allow_self_enrollment' => 'sometimes|required|boolean',
            'teacher_id' => $isAdmin
                ? 'sometimes|required|integer|exists:teachers,id'
                : 'prohibited',
            'subject_id' => 'sometimes|nullable|integer|exists:subjects,id',
            'class_group_id' => 'sometimes|nullable|integer|exists:class__groups,id',
            'academic__period_id' => 'sometimes|nullable|integer|exists:academic__periods,id',
        ]);

        $dates = [
            'enrollment_opens_at' => $data['enrollment_opens_at'] ?? $module->enrollment_opens_at,
            'enrollment_closes_at' => $data['enrollment_closes_at'] ?? $module->enrollment_closes_at,
        ];
        Validator::make($dates, [
            'enrollment_closes_at' => 'after_or_equal:enrollment_opens_at',
        ])->validate();

        $module->update($data);

        return response()->json($module);
    }

    public function destroy(Request $request, Module $module)
    {
        $this->authorizeManagement($request->user(), $module);
        $module->delete();

        return response()->json($module);
    }

    private function roleSlug(?UserSystem $user): string
    {
        return Str::slug($user?->rol?->slug ?? $user?->rol?->name_role ?? '');
    }

    private function isTeacher(?UserSystem $user): bool
    {
        return in_array($this->roleSlug($user), ['teacher', 'docente', 'profesor', 'profesora'], true);
    }

    private function isAdmin(?UserSystem $user): bool
    {
        return in_array($this->roleSlug($user), ['admin', 'administrador', 'administrator'], true);
    }

    private function teacherFor(?UserSystem $user): ?Teacher
    {
        return $user
            ? Teacher::where('user_system_id', $user->id)->first()
            : null;
    }

    private function authorizeManagement(?UserSystem $user, Module $module): void
    {
        if ($this->isTeacher($user)) {
            $teacher = $this->teacherFor($user);
            abort_unless($teacher && (int) $module->teacher_id === (int) $teacher->id, 404);
            return;
        }

        abort_unless($this->isAdmin($user), 403, 'No tienes permiso para modificar módulos.');
    }
}
