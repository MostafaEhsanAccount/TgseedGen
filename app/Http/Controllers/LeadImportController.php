<?php

namespace App\Http\Controllers;

use App\Jobs\ImportLeadsJob;
use App\Models\ImportBatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LeadImportController extends Controller
{
    /**
     * @var list<string>
     */
    private const MAPPABLE_FIELDS = [
        'name', 'company', 'phone', 'email', 'website',
        'industry', 'address', 'city', 'country', 'notes',
    ];

    public function create(): View
    {
        return view('leads.import.create');
    }

    public function preview(Request $request): View
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $originalFilename = $request->file('file')->getClientOriginalName();
        $storedPath = $request->file('file')->storeAs('imports', Str::uuid().'.csv', 'local');

        $handle = fopen(Storage::disk('local')->path($storedPath), 'r');
        $headers = fgetcsv($handle) ?: [];
        fclose($handle);

        return view('leads.import.mapping', [
            'headers' => $headers,
            'storedPath' => $storedPath,
            'originalFilename' => $originalFilename,
            'mappableFields' => self::MAPPABLE_FIELDS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'stored_path' => ['required', 'string'],
            'original_filename' => ['required', 'string'],
            'mapping' => ['required', 'array'],
            'mapping.*' => ['required', 'string'],
        ]);

        if (! Storage::disk('local')->exists($validated['stored_path'])) {
            abort(419);
        }

        $batch = ImportBatch::create([
            'user_id' => $request->user()->id,
            'original_filename' => $validated['original_filename'],
            'column_mapping' => $validated['mapping'],
            'status' => 'processing',
        ]);

        ImportLeadsJob::dispatch($batch->id, $validated['stored_path'], $validated['mapping']);

        return redirect()->route('leads.import.show', $batch)
            ->with('status', __('leads.import_queued'));
    }

    public function show(ImportBatch $batch): View
    {
        // No dedicated policy: the tenant global scope on ImportBatch already
        // makes route model binding 404 for another tenant's batch.
        return view('leads.import.show', ['batch' => $batch]);
    }
}
