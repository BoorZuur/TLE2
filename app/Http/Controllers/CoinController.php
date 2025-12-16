<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CoinController extends Controller
{
    public function getCoins()
    {
        return response()->json([
            'coins' => Auth::user()->coins
        ]);
    }

    public function addCoins(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $key = "pet_cooldown_user_{$user->id}";

        if (Cache::has($key)) {
            return response()->json(['error' => 'cooldown'], 429);
        }

        // 300ms cooldown
        Cache::put($key, true, now()->addMilliseconds(300));

        $user->increment('coins', 1);

        return response()->json([
            'coins' => $user->coins
        ]);
    }
}
