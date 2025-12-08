<?php

namespace App\Http\Controllers;

use App\Models\Specie;
use App\Models\UserSpeciesUnlock;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $region = $request->query('region');

            $query = \App\Models\Specie::with('habitat');

            if ($region) {
                $query->whereHas('habitat', fn($q) => $q->where('name', $region));
            }

            $species = $query->get();

            $unlockedIds = $user
                ? \App\Models\UserSpeciesUnlock::where('user_id', $user->id)->pluck('species_id')->toArray()
                : [];

            $result = $species->map(fn($specie) => [
                'vernacularName' => $specie->name,
                'scientificName' => $specie->scientific_name ?? '-',
                'location' => $specie->habitat->name ?? '-',
                'beheerder' => $specie->beheerder ?? '-',
                'image' => $specie->image ?? '/images/placeholder.jpg',
                'locked' => !in_array($specie->id, $unlockedIds),
                'info' => $specie->info ?? '-',
                'id' => $specie->id,
            ]);

            return response()->json($result->values());

        } catch (\Throwable $e) {
            \Log::error('CollectionController@index error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Er is iets misgegaan bij het ophalen van de dieren.'
            ], 500);
        }
    }

}
