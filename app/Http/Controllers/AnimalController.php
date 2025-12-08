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
            \Log::info('Initialized last_hunger_update', ['animal_id' => $animal->id, 'time' => $now]);
        } else {
            $secondsPassed = $animal->last_hunger_update->diffInSeconds($now);
            \Log::info('Checking hunger', [
                'animal_id' => $animal->id,
                'seconds_passed' => $secondsPassed,
                'last_update' => $animal->last_hunger_update,
                'now' => $now
            ]);

            // change this
            if ($secondsPassed >= 5) {
                $decrease = floor($secondsPassed / 2);
                $animal->hunger = max(0, $animal->hunger - $decrease);
                $animal->last_hunger_update = $now;
                $animal->save();
                \Log::info('Saved hunger update', ['animal_id' => $animal->id, 'new_hunger' => $animal->hunger]);
            } else {
                \Log::info('Skipped save - not enough time passed', ['animal_id' => $animal->id, 'seconds' => $secondsPassed]);
            }
        }

        return response()->json([
            'hunger' => $animal->hunger,
            'last_hunger_update' => $animal->last_hunger_update->toIso8601String()
        ]);
    }

    public function feed(Animal $animal)
    {
        $now = now();
        $lastFed = $animal->last_fed ?? now()->subMinutes(5);

        $secondsSinceFed = $lastFed->diffInSeconds($now);

        if ($secondsSinceFed < 10) {
            return response()->json(['error' => 'cooldown'], 429);
        }

        $animal->hunger = min(100, $animal->hunger + 20);
        $animal->last_fed = $now;
        $animal->last_hunger_update = $now;
        $animal->save();

        return response()->json([
            'hunger' => $animal->hunger
        ]);
    }
}
