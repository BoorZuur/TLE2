<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $user->coins += 1;
        $user->save();

        return response()->json([
            'coins' => $user->coins
        ]);
    }
}
