<?php

namespace App\Http\Controllers;

use App\Models\PredictionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredictionRecordController extends Controller
{
    // List all PredictionRecords belonging to the authenticated user
    public function index()
    {
        $records = PredictionRecord::with(['anak', 'antropometryRecord', 'user'])
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($records);
    }

    // Store a new PredictionRecord
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anak_id'                 => 'required|exists:anaks,id',
            'antropometry_record_id'  => 'required|exists:antropometry_records,id',
            'status_stunting'         => 'required|string',
            'status_underweight'      => 'required|string',
            'status_wasting'          => 'required|string',
            'recommendation'          => 'nullable|string',
        ]);

        $record = PredictionRecord::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        $record->load(['anak', 'antropometryRecord', 'user']);

        return response()->json($record, 201);
    }

    // Show a single PredictionRecord with relations
    public function show($id)
    {
        $record = PredictionRecord::with(['anak', 'antropometryRecord', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($record);
    }

    // Update an existing PredictionRecord
    public function update(Request $request, $id)
    {
        $record = PredictionRecord::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'status_stunting'    => 'sometimes|required|string',
            'status_underweight' => 'sometimes|required|string',
            'status_wasting'     => 'sometimes|required|string',
            'recommendation'     => 'nullable|string',
        ]);

        $record->update($validated);
        $record->load(['anak', 'antropometryRecord', 'user']);

        return response()->json($record);
    }

    // Delete a PredictionRecord
    public function destroy($id)
    {
        $record = PredictionRecord::where('user_id', Auth::id())->findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
