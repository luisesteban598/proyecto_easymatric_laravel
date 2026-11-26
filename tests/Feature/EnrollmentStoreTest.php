<?php

namespace Tests\Feature;

use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_generates_unique_code_when_missing_and_preserves_provided_code(): void
    {
        $response = $this->postJson('/v1/enrollments/store', [
            'enrollment_date' => '2026-11-26',
            'status' => 'pendiente',
            'shift' => 'Mañana',
        ])->assertOk();

        $generatedCode = $response->json('enrollment_code');

        $this->assertMatchesRegularExpression('/^MAT-' . now()->format('Y') . '-[A-Z0-9]{8}$/', $generatedCode);
        $this->assertDatabaseHas('enrollments', ['enrollment_code' => $generatedCode]);

        $secondGeneratedCode = $this->postJson('/v1/enrollments/store', [
            'enrollment_date' => '2026-11-26',
            'status' => 'pendiente',
            'shift' => 'Mañana',
        ])->assertOk()->json('enrollment_code');

        $this->assertNotSame($generatedCode, $secondGeneratedCode);

        $providedCode = 'MAT-MANUAL-001';

        $this->postJson('/v1/enrollments/store', [
            'enrollment_date' => '2026-11-26',
            'status' => 'pendiente',
            'enrollment_code' => $providedCode,
            'shift' => 'Mañana',
        ])->assertOk()->assertJsonPath('enrollment_code', $providedCode);

        $this->assertSame(3, Enrollment::count());
        $this->assertNotSame($generatedCode, $providedCode);
    }
}
