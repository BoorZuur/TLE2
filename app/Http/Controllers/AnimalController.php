<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Get a specific animal by ID (for /animal/{id})
     */
    public function get(string $id)
    {
        $animal = Animal::findOrFail($id);

        // Check if this animal belongs to the authenticated user
        if ($animal->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'id' => $animal->id,
            'name' => $animal->name,
            'hunger' => $animal->hunger ?? 100,
            'cleanliness' => $animal->cleanliness ?? 100,
            'happiness' => $animal->happiness ?? 100,
        ]);
    }

    /**
     * Show the animal view page (for /animal/{id})
     */
    public function show(string $id)
    {
        $animal = Animal::findOrFail($id);

        if ($animal->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('animals.show', compact('animal'));
    }

    /**
     * Update a specific animal by ID
     */
    public function update(Request $request, string $id)
    {
        $animal = Animal::findOrFail($id);

        // Check if this animal belongs to the authenticated user
        if ($animal->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'hunger' => 'nullable|integer|min:0|max:100',
            'cleanliness' => 'nullable|integer|min:0|max:100',
            'happiness' => 'nullable|integer|min:0|max:100',
        ]);

        // Update only the fields provided
        if ($request->has('hunger')) {
            $animal->hunger = $validated['hunger'];
        }
        if ($request->has('cleanliness')) {
            $animal->cleanliness = $validated['cleanliness'];
        }
        if ($request->has('happiness')) {
            $animal->happiness = $validated['happiness'];
        }

        $animal->save();

        return response()->json([
            'success' => true,
            'hunger' => $animal->hunger,
            'cleanliness' => $animal->cleanliness,
            'happiness' => $animal->happiness,
        ]);
    }
}
