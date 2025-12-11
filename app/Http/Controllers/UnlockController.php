<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSpeciesUnlock;

class UnlockController extends Controller
{
    //When a user unlocks a species, create a new record in the user_species_unlocks table
    //When does this happen?
        // When a user registers (starting animal 'fluffy')
        // When a user buys/adopts an animal from the shop
        // When a user receives a reward (QR code scanning)

    public function unlockSpecies(Request $request, $speciesId)
    {
        $user = $request->user();

        // Check if the species is already unlocked
        $alreadyUnlocked = UserSpeciesUnlock::where('user_id', $user->id)
            ->where('species_id', $speciesId)
            ->exists();

        if ($alreadyUnlocked) {
            return response()->json(['message' => 'Species already unlocked'], 200);
        }

        // Unlock the species for the user
        UserSpeciesUnlock::create([
            'user_id' => $user->id,
            'species_id' => $speciesId,
        ]);

        return response()->json(['message' => 'Species unlocked successfully'], 201);
    }
}
