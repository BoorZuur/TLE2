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

    public function getAreas()
    {
        $habitats = \App\Models\Habitat::with('species')->get();

        $areas = $habitats->map(function ($habitat) {
            return [
                'id' => $habitat->id,
                'name' => $habitat->name,
                'description' => $habitat->description,
                'info_image' => $habitat->info_image,
                'images' => [
                    0 => $habitat->image_0,
                    20 => $habitat->image_20,
                    40 => $habitat->image_40,
                    60 => $habitat->image_60,
                    80 => $habitat->image_80,
                    100 => $habitat->image_100,
                ],
                'animals' => $habitat->species->pluck('name')->values(),
            ];
        });

        return response()->json([
            'areas' => $areas
        ]);
    }
}
