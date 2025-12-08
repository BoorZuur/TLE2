<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function getHunger(Animal $animal)
    {
        $now = now();

        if ($animal->last_hunger_update === null) {
            $animal->last_hunger_update = $now;
            $animal->save();

            return response()->json([
                'hunger' => $animal->hunger,
            ]);
        }

        $secondsPassed = $now->diffInSeconds($animal->last_hunger_update);

        if ($secondsPassed > 0) {
            $decrease = floor($secondsPassed / 3);
            $animal->hunger = max(0, $animal->hunger - $decrease);
            $animal->last_hunger_update = now();
            $animal->save();
        }

        return response()->json([
            'hunger' => $animal->hunger
        ]);
    }

    public function feed(Animal $animal)
    {
        $now = now();
        $lastFed = $animal->last_fed ?? now()->subMinutes(5);

        $secondsSinceFed = $now->diffInSeconds($lastFed);

        if ($secondsSinceFed < 60) {
            return response()->json(['error' => 'cooldown'], 429);
        }

        $animal->hunger = min(100, $animal->hunger + 20);
        $animal->last_fed = $now;
        $animal->save();

        return response()->json([
            'hunger' => $animal->hunger
        ]);
    }
}
