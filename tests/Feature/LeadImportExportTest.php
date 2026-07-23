<?php

namespace Tests\Feature;

use App\Models\ImportBatch;
use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadImportExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_page_loads(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user)->get(route('leads.import.create'))->assertOk();
    }

    public function test_uploading_a_csv_shows_the_column_mapping_form(): void
    {
        Storage::fake('local');

        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $csv = UploadedFile::fake()->createWithContent('leads.csv', "name,phone,email\nAhmed,0111111111,ahmed@example.com\n");

        $this->actingAs($user)
            ->post(route('leads.import.preview'), ['file' => $csv])
            ->assertOk()
            ->assertSee('name')
            ->assertSee('phone')
            ->assertSee('email');
    }

    public function test_a_non_csv_file_is_rejected(): void
    {
        Storage::fake('local');

        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $image = UploadedFile::fake()->image('photo.jpg');

        $this->actingAs($user)
            ->post(route('leads.import.preview'), ['file' => $image])
            ->assertSessionHasErrors('file');
    }

    public function test_importing_creates_leads_skips_duplicates_and_flags_missing_names(): void
    {
        Storage::fake('local');

        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $stage = $tenant->pipelineStages()->orderBy('order')->first();

        Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stage->id,
            'created_by' => $user->id,
            'phone' => '0100009999',
        ]);

        $csv = UploadedFile::fake()->createWithContent(
            'leads.csv',
            "name,phone\nNew Lead One,0111111111\n,0122222222\nDuplicate Lead,0100009999\n"
        );

        $this->actingAs($user);

        $preview = $this->post(route('leads.import.preview'), ['file' => $csv]);
        $storedPath = $preview->viewData('storedPath');

        $response = $this->post(route('leads.import.store'), [
            'stored_path' => $storedPath,
            'original_filename' => 'leads.csv',
            'mapping' => ['0' => 'name', '1' => 'phone'],
        ]);

        $batch = ImportBatch::first();
        $response->assertRedirect(route('leads.import.show', $batch));

        $batch->refresh();
        $this->assertSame(3, $batch->total_rows);
        $this->assertSame(1, $batch->imported_rows);
        $this->assertSame(1, $batch->skipped_rows);
        $this->assertSame(1, $batch->failed_rows);
        $this->assertSame('completed_with_errors', $batch->status);
        $this->assertCount(2, $batch->error_log);

        $this->assertSame(2, Lead::count()); // the pre-existing one + the one new import
        $this->assertTrue(Lead::where('phone', '0111111111')->where('source', 'import')->exists());
    }

    public function test_export_returns_a_csv_of_matching_leads(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $stage = $tenant->pipelineStages()->orderBy('order')->first();

        Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $user->id, 'name' => 'Exportable Lead', 'company' => 'Acme',
        ]);
        Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $user->id, 'name' => 'Other Lead', 'company' => 'Other Co',
        ]);

        $response = $this->actingAs($user)->get(route('leads.export', ['search' => 'Exportable']));

        $response->assertOk();
        $content = $response->streamedContent();
        $this->assertStringContainsString('Exportable Lead', $content);
        $this->assertStringNotContainsString('Other Lead', $content);
    }
}
