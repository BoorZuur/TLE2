<?php

namespace App\Http\Controllers;

use App\Services\BiodiversityService;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    protected $bio;

    public function __construct(BiodiversityService $bio)
    {
        $this->bio = $bio;
    }

    public function index(Request $request)
    {
        $region = $request->query('region', null);

        if (!$region) {
            // Drie gebieden
            $regions = ['area1', 'area2', 'area3'];
            $animals = [];
            foreach ($regions as $area) {
                $animals = array_merge($animals, $this->bio->getAnimalsInArea($area));
            }
        } else {
            $animals = $this->bio->getAnimalsInArea($region);
        }

        return response()->json($animals);
    }
}
