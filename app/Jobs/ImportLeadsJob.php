<?php

namespace App\Jobs;

use App\Models\ImportBatch;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportLeadsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $columnMapping  CSV column index => lead field name (or 'ignore')
     */
    public function __construct(
        public int $importBatchId,
        public string $storedFilePath,
        public array $columnMapping,
    ) {}

    public function handle(): void
    {
        $batch = ImportBatch::findOrFail($this->importBatchId);

        $handle = fopen(Storage::disk('local')->path($this->storedFilePath), 'r');
        fgetcsv($handle); // skip header row, already reflected in columnMapping

        $totalRows = 0;
        $imported = 0;
        $skipped = 0;
        $failed = 0;
        $errorLog = [];

        while (($row = fgetcsv($handle)) !== false) {
            $totalRows++;

            $fields = $this->mapRow($row);

            if (empty($fields['name'] ?? null)) {
                $failed++;
                $errorLog[] = ['row' => $totalRows, 'reason' => 'Missing required "name" field'];

                continue;
            }

            if ($this->isDuplicate($batch->tenant_id, $fields['phone'] ?? null, $fields['email'] ?? null)) {
                $skipped++;
                $errorLog[] = ['row' => $totalRows, 'reason' => 'Duplicate phone or email'];

                continue;
            }

            Lead::create([
                'tenant_id' => $batch->tenant_id,
                'pipeline_stage_id' => $batch->tenant->pipelineStages()->orderBy('order')->first()->id,
                'created_by' => $batch->user_id,
                'source' => 'import',
                ...$fields,
            ]);

            $imported++;
        }

        fclose($handle);
        Storage::disk('local')->delete($this->storedFilePath);

        $batch->update([
            'total_rows' => $totalRows,
            'imported_rows' => $imported,
            'skipped_rows' => $skipped,
            'failed_rows' => $failed,
            'error_log' => $errorLog,
            'status' => $failed > 0 || $skipped > 0
                ? ($imported > 0 ? 'completed_with_errors' : 'failed')
                : 'completed',
        ]);
    }

    /**
     * @param  array<int, string|null>  $row
     * @return array<string, string>
     */
    private function mapRow(array $row): array
    {
        $fields = [];

        foreach ($this->columnMapping as $index => $leadField) {
            if ($leadField === 'ignore' || ! isset($row[$index])) {
                continue;
            }

            $value = trim($row[$index]);

            if ($value !== '') {
                $fields[$leadField] = $value;
            }
        }

        return $fields;
    }

    private function isDuplicate(int $tenantId, ?string $phone, ?string $email): bool
    {
        if (! $phone && ! $email) {
            return false;
        }

        return Lead::where('tenant_id', $tenantId)
            ->where(function ($query) use ($phone, $email) {
                if ($phone) {
                    $query->orWhere('phone', $phone);
                }
                if ($email) {
                    $query->orWhere('email', $email);
                }
            })
            ->exists();
    }
}
