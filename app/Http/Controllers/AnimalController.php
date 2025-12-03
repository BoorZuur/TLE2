<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function feed(Animal $animal)
    {
        if ($animal->user_id !== auth()->id()) {
            abort(403);
        }

        $animal->hunger = min(100, $animal->hunger + 10);
        $animal->save();

        return response()->json([
            'success' => true,
            'hunger' => $animal->hunger,
            'message' => $animal->name . ' has been fed!'
        ]);
    }


}
