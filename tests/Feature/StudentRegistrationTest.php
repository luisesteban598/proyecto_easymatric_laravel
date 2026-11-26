<?php

namespace Tests\Feature;

use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_registration_creates_a_searchable_student_record(): void
    {
        $role = Rol::create([
            'name_role' => 'Estudiante',
            'slug' => 'estudiante',
            'description' => 'Rol de estudiante',
        ]);

        $registration = $this->postJson('/v1/user-systems/store', [
            'first_name' => 'Camilo',
            'last_name' => 'Flor',
            'document' => '10369852',
            'document_type' => 'CC',
            'email' => 'camilo@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'username' => 'camilo-flor',
            'status' => true,
            'rol_id' => $role->id,
        ])->assertCreated()
            ->assertJsonPath('data.student.document', '10369852')
            ->assertJsonPath('data.student.document_type', 'CC');

        $studentId = $registration->json('data.student.id');

        $this->getJson('/v1/students/by-document?document=10369852&document_type=CC')
            ->assertOk()
            ->assertJsonPath('data.id', $studentId);

        $this->getJson('/v1/students/by-document?document=10369852&document_type=')
            ->assertOk()
            ->assertJsonPath('data.id', $studentId);

        $this->getJson('/v1/students/by-document?document=10369852')
            ->assertOk()
            ->assertJsonPath('data.id', $studentId);

        $this->getJson('/v1/students/by-document?document=10369852&document_type=TI')
            ->assertNotFound()
            ->assertJsonPath('message', 'No se encontró un estudiante con el documento indicado.');
    }
}
