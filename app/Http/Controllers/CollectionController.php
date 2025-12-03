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

    /**
     * Haal dieren op uit NBA API of gebruik dummy data als fallback.
     * Querystring: ?region=<naam> om een specifiek gebied op te vragen
     */
    public function index(Request $request)
    {
        $region = $request->query('region', null);
        $defaultLocalities = config('animals.defaultLocalities', ['Veluwe', 'Lauwersmeer', 'Weerribben-Wieden']);

        if ($region) {
            $animals = $this->bio->getAnimalsForLocalities([$region]);
        } else {
            $animals = $this->bio->getAnimalsForLocalities($defaultLocalities);
        }

        // fallback naar dummy data, ook gefilterd op region
        if (!is_array($animals) || empty($animals)) {
            $animals = collect(config('animals.dummyAnimals', []))
                ->when($region, fn($query) => $query->where('location', $region))
                ->values()
                ->all();
        }

        return response()->json($animals);
    }
}
