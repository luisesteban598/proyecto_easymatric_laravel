<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\Module_Enrollment;
use App\Models\Rol;
use App\Models\UserSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TeacherModuleIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_login_only_lists_and_opens_modules_owned_by_their_profile(): void
    {
        $role = Rol::create([
            'name_role' => 'Docente',
            'slug' => 'docente',
            'description' => 'Rol de docente',
        ]);
        $institutionId = DB::table('institutions')->insertGetId([
            'name_institution' => 'Institución de prueba',
            'email_institution' => 'institution@example.test',
            'phone_institution' => '3000000000',
            'address_institution' => 'Calle 1',
            'description_institution' => 'Prueba',
            'nit' => '900000001',
            'city' => 'Popayán',
            'logo_url' => 'https://example.test/logo.png',
            'logo_public_id' => 'logo-test',
            'imagen_url' => 'https://example.test/facade.png',
            'imagen_public_id' => 'facade-test',
            'class_start_date' => '2026-01-01',
            'class_end_date' => '2026-12-31',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $firstTeacher = $this->createTeacher($role, $institutionId, 'ana');
        $secondTeacher = $this->createTeacher($role, $institutionId, 'luis');
        $firstModule = $this->createModule($firstTeacher['teacher_id'], 'Módulo de Ana');
        $secondModule = $this->createModule($secondTeacher['teacher_id'], 'Módulo de Luis');
        Module_Enrollment::create([
            'status' => 'Inscrito',
            'module_id' => $firstModule->id,
        ]);
        Module_Enrollment::create([
            'status' => 'Inscrito',
            'module_id' => $secondModule->id,
        ]);

        $this->getJson('/v1/teachers/list')
            ->assertOk()
            ->assertJsonPath('0.user_system.first_name', 'Ana')
            ->assertJsonPath('0.user_system.last_name', 'Docente');

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->getJson('/v1/teacher/profile')
            ->assertOk()
            ->assertJsonPath('teacher.id', $firstTeacher['teacher_id'])
            ->assertJsonPath('teacher.user.email', 'ana@example.test')
            ->assertJsonPath('teacher.institution.name_institution', 'Institución de prueba');

        $unlinkedUser = UserSystem::create([
            'first_name' => 'Sin',
            'last_name' => 'Perfil',
            'document' => 'DOC-ORPHAN',
            'document_type' => 'CC',
            'phone' => '3000000000',
            'email' => 'orphan@example.test',
            'password' => Hash::make('password123'),
            'photo_url' => '',
            'photo_public_id' => '',
            'username' => 'orphan',
            'status' => true,
            'institution_id' => $institutionId,
            'rol_id' => $role->id,
        ]);
        $this->assertDatabaseMissing('teachers', ['user_system_id' => $unlinkedUser->id]);
        $this->app['auth']->forgetGuards();
        $this->withToken($unlinkedUser->createToken('test')->plainTextToken)
            ->getJson('/v1/teacher/profile')
            ->assertForbidden()
            ->assertJsonPath('message', 'La cuenta no tiene un perfil docente asociado.');

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->getJson('/v1/modules/list')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $firstModule->id);

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->getJson('/v1/modules/' . $firstModule->id)
            ->assertOk()
            ->assertJsonPath('id', $firstModule->id);

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->getJson('/v1/module-enrollments/list')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.module_id', $firstModule->id);

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->getJson("/v1/modules/{$secondModule->id}")
            ->assertNotFound();

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->putJson("/v1/modules/{$firstModule->id}", ['name_module' => 'Módulo corregido'])
            ->assertOk()
            ->assertJsonPath('name_module', 'Módulo corregido')
            ->assertJsonPath('description_module', 'Módulo de prueba');

        $this->app['auth']->forgetGuards();
        $this->withToken($firstTeacher['token'])
            ->putJson("/v1/modules/{$secondModule->id}", ['name_module' => 'No autorizado'])
            ->assertNotFound();

        foreach (['1', '0'] as $booleanValue) {
            $this->app['auth']->forgetGuards();
            $this->withToken($firstTeacher['token'])
                ->postJson('/v1/modules/store', [
                    'name_module' => 'Módulo de prueba',
                    'description_module' => 'Descripción',
                    'schedule' => 'Lunes',
                    'duration' => '12 semanas',
                    'seats' => 20,
                    'weekly_hours' => 2,
                    'enrollment_opens_at' => '2026-01-01',
                    'enrollment_closes_at' => '2026-12-01',
                    'allow_self_enrollment' => $booleanValue,
                    'is_published' => '1',
                ])
                ->assertUnprocessable()
                ->assertJsonValidationErrors(['syllabus'])
                ->assertJsonMissingValidationErrors(['allow_self_enrollment']);
        }
    }

    private function createTeacher(Rol $role, int $institutionId, string $suffix): array
    {
        $this->postJson('/v1/user-systems/store', [
            'first_name' => ucfirst($suffix),
            'last_name' => 'Docente',
            'document' => "DOC-{$suffix}",
            'document_type' => 'CC',
            'phone' => '3000000000',
            'email' => "{$suffix}@example.test",
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'username' => $suffix,
            'status' => true,
            'institution_id' => $institutionId,
            'rol_id' => $role->id,
            'specialty' => 'Matemáticas',
        ])->assertCreated()
            ->assertJsonPath('data.teacher.specialty', 'Matemáticas');

        $login = $this->postJson('/v1/login', [
            'identifier' => "{$suffix}@example.test",
            'password' => 'password123',
        ])->assertOk()
            ->assertJsonPath('user.teacher_id', DB::table('teachers')
                ->where('user_system_id', DB::table('user_systems')->where('username', $suffix)->value('id'))
                ->value('id'));

        return [
            'token' => $login->json('token'),
            'teacher_id' => $login->json('user.teacher_id'),
        ];
    }

    private function createModule(int $teacherId, string $name): Module
    {
        return Module::create([
            'name_module' => $name,
            'description_module' => 'Módulo de prueba',
            'schedule' => 'Lunes',
            'duration' => '12 semanas',
            'seats' => 20,
            'syllabus_url' => 'https://example.test/syllabus.png',
            'syllabus_public_id' => 'syllabus-test',
            'weekly_hours' => 2,
            'enrollment_opens_at' => '2026-01-01',
            'enrollment_closes_at' => '2026-12-01',
            'allow_self_enrollment' => true,
            'is_published' => true,
            'teacher_id' => $teacherId,
        ]);
    }
}
