<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specie;
use App\Models\Habitat;

class SpecieSeeder extends Seeder
{
    public function run(): void
    {
        $dummyAnimals = config('animals.dummyAnimals', []);

        foreach ($dummyAnimals as $animal) {
            // Haal habitat id op uit naam
            $habitat = Habitat::firstWhere('name', $animal['location']);
            if (!$habitat) continue;

            // Zorg dat image altijd vanaf public/ wordt gelezen
            $imagePath = $animal['image'] ?? '/images/placeholder.png';
            if ($imagePath[0] !== '/') {
                $imagePath = '/' . $imagePath;
            }

            Specie::updateOrCreate(
                [
                    'name' => $animal['vernacularName'],
                    'habitat_tag' => $habitat->id
                ],
                [
                    'scientific_name' => $animal['scientificName'] ?? '-',
                    'beheerder' => $animal['beheerder'] ?? '-',
                    'image' => $imagePath,
                    'info' => $animal['info'] ?? '-',
                    'locked' => $animal['locked'] ?? true,
                ]
            );
        }
    }
}
