<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnergyController extends Controller
{
    public function getEnergy()
    {
        return response()->json([
            'energy' => Auth::user()->energy
        ]);
    }

    public function addEnergy(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
        ]);

        $user = Auth::user();
        $user->energy += $request->amount;

        $user->save();

        return response()->json([
            'energy' => $user->energy
        ]);
    }
}
