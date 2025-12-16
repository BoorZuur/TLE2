<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AnimalController extends Controller
{
    public function getHunger(Animal $animal)
    {
        $now = now();

        if ($animal->last_hunger_update === null) {
            $animal->last_hunger_update = $now;
            $animal->save();
        } else {
            $secondsPassed = $animal->last_hunger_update->diffInSeconds($now);

            // server side honger decrease, waarde veranderen
            if ($secondsPassed >= 30) {
                $decrease = floor($secondsPassed / 20);
                $animal->hunger = max(0, $animal->hunger - $decrease);
                $animal->last_hunger_update = $now;
                $animal->save();
            }
        }

        return response()->json([
            'hunger' => $animal->hunger,
            'last_hunger_update' => $animal->last_hunger_update->toIso8601String(),
            'coins' => auth()->user()->coins
        ]);
    }

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
            'hunger' => $animal->hunger,
            'cleanliness' => $animal->cleanliness,
            'happiness' => $animal->happiness,
            'last_hunger_update' => $animal->last_hunger_update->toIso8601String()
        ]);
    }

    public function feed(Animal $animal)
    {
        $now = now();
        $lastFed = $animal->last_fed ?? now()->subMinutes(5);

        //cooldown voor eten geven
        $cooldown = 10;
        $secondsSinceFed = $lastFed->diffInSeconds($now);
        $remaining = max(0, $cooldown - $secondsSinceFed);

        if ($secondsSinceFed < $cooldown) {
            return response()->json(['error' => 'cooldown', 'remaining' => $remaining], 429);
        }

        $animal->hunger = min(100, $animal->hunger + 20);
        $animal->last_fed = $now;
        $animal->last_hunger_update = $now;
        $animal->save();

        $user = Auth::user();
        $user->coins += 20;
        $user->save();

        return response()->json([
            'hunger' => $animal->hunger,
            'coins' => $animal->coins
        ]);
    }
}
