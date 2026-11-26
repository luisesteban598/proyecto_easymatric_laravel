<?php

namespace Tests\Feature;

use App\Http\Controllers\EnrollmentDocumentController;
use App\Models\Requirement_Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class EnrollmentDocumentStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_uploads_and_persists_document_using_schema_column_names(): void
    {
        $requirementType = Requirement_Type::create([
            'name' => 'Documento de identidad',
            'code' => 'IDENTITY',
            'is_required' => true,
            'applies_to_cycle' => '2026',
        ]);

        $controller = Mockery::mock(EnrollmentDocumentController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('uploadToCloudinary')
            ->once()
            ->andReturn([
                'secure_url' => 'https://example.test/enrollment-document.png',
                'public_id' => 'enrollmentDocuments/document-123',
            ]);
        $this->app->instance(EnrollmentDocumentController::class, $controller);

        $this->post('/v1/enrollment-documents/store', [
            'status' => 'pending',
            'requirement_type_id' => $requirementType->id,
            'imagen' => UploadedFile::fake()->createWithContent(
                'document.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=')
            ),
        ])->assertCreated()
            ->assertJsonPath('data.requirement__type_id', $requirementType->id)
            ->assertJsonPath('data.file_url', 'https://example.test/enrollment-document.png')
            ->assertJsonPath('data.file_public_id', 'enrollmentDocuments/document-123');

        $this->assertDatabaseHas('enrollment__documents', [
            'status' => 'pending',
            'requirement__type_id' => $requirementType->id,
            'file_url' => 'https://example.test/enrollment-document.png',
            'file_public_id' => 'enrollmentDocuments/document-123',
        ]);
    }
}
