<?php

namespace App\Http\Controllers;

use App\Models\AntropometryRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntropometryRecordController extends Controller
{
    public function index()
    {
        $records = AntropometryRecord::with(['anak', 'predictionRecord', 'user'])
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($records);
    }

    // Store a new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anak_id'                => 'required|exists:anaks,id',
            'age_in_month'           => 'required|integer',
            'weight'                 => 'required|numeric',
            'height'                 => 'required|numeric',
            'vitamin_a_count'        => 'nullable|integer',
            'head_circumference'     => 'nullable|numeric',
            'upper_arm_circumference'=> 'nullable|numeric',
        ]);

        $record = AntropometryRecord::create([
            ...$validated,
            'user_id' => Auth::id()
        ]);

        // Eager load related data
        $record->load(['anak', 'predictionRecord', 'user']);

        return response()->json($record, 201);
    }

    // Show a single record (with relations)
    public function show($id)
    {
        $record = AntropometryRecord::with(['anak', 'predictionRecord', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($record);
    }

    // Update a record
    public function update(Request $request, $id)
    {
        $record = AntropometryRecord::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'age_in_month'           => 'sometimes|integer',
            'weight'                 => 'sometimes|numeric',
            'height'                 => 'sometimes|numeric',
            'vitamin_a_count'        => 'nullable|integer',
            'head_circumference'     => 'nullable|numeric',
            'upper_arm_circumference'=> 'nullable|numeric',
        ]);

        $record->update($validated);

        $record->load(['anak', 'predictionRecord', 'user']);

        return response()->json($record);
    }

    // Delete a record
    public function destroy($id)
    {
        $record = AntropometryRecord::where('user_id', Auth::id())->findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

