<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnakController extends Controller
{
    // List all Anak for authenticated user
    public function index()
    {
        $anak = Anak::with(['user', 'antropometryRecords', 'predictionRecords'])
            ->where('user_id', Auth::id())
            ->get();

        if ($anak->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($anak);
    }

    // Store new Anak
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|string',
            'birth_date' => 'required|date',
            'region' => 'required|string',
            'father_edu' => 'nullable|string',
            'mother_edu' => 'nullable|string',
        ]);

        $anak = Anak::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return response()->json($anak, 201);
    }

    // Show specific Anak (belongs to user)
    public function show($id)
    {
        $anak = Anak::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($anak);
    }

    // Update specific Anak
    public function update(Request $request, $id)
    {
        $anak = Anak::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'gender' => 'sometimes|required|string',
            'birth_date' => 'sometimes|required|date',
            'region' => 'sometimes|required|string',
            'father_edu' => 'nullable|string',
            'mother_edu' => 'nullable|string',
        ]);

        $anak->update($validated);

        return response()->json($anak);
    }

    // Delete specific Anak
    public function destroy($id)
    {
        $anak = Anak::where('user_id', Auth::id())->findOrFail($id);
        $anak->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

