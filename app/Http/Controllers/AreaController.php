<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getArea(Request $request)
    {
        $collected = Animal::where('user_id', auth()->id())
            ->with('species')
            ->get()
            ->pluck('species.name')
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'collected' => $collected
        ]);
    }
}
