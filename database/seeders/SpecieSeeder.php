<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specie;
use App\Models\Habitat;

class SpecieSeeder extends Seeder
{
    public function run(): void
    {
        $speciesData = [
            [
                'name' => 'Konijn',
                'scientific_name' => 'Oryctolagus cuniculus',
                'habitat_name' => 'Veluwe',
                'info' => 'Een schattig konijn dat graag huppelt.',
                'image' => '/images/konijn.png',
                'beheerder' => 'Natuurmonumenten',
            ],
            [
                'name' => 'Eend',
                'scientific_name' => 'Anas platyrhynchos',
                'habitat_name' => 'Beekdal',
                'info' => 'Een vrolijke eend die graag zwemt.',
                'image' => '/images/eend.jpg',
                'beheerder' => 'Staatsbosbeheer',
            ],
            [
                'name' => 'Vos',
                'scientific_name' => 'Vulpes vulpes',
                'habitat_name' => 'Veluwe',
                'info' => 'Een slimme en speelse vos.',
                'image' => '/images/cheerful-fox.png',
                'beheerder' => 'Natuurmonumenten',
            ],
            [
                'name' => 'Edelhert',
                'scientific_name' => 'Cervus elaphus',
                'habitat_name' => 'Veluwe',
                'info' => 'Een majestueus edelhert.',
                'image' => '/images/edelhert.avif',
                'beheerder' => 'Staatsbosbeheer',
            ],
            [
                'name' => 'Boomkikker',
                'scientific_name' => 'Hyla arborea',
                'habitat_name' => 'Veluwe',
                'info' => 'Een zeldzame boomkikker met prachtige kleuren.',
                'image' => '/images/boomkikker.avif',
                'beheerder' => 'Natuurmonumenten',
            ],
            [
                'name' => 'Bunzing',
                'scientific_name' => 'Mustela putorius',
                'habitat_name' => 'Beekdal',
                'info' => 'Een zeldzaam dier met een knuffelig uiterlijk.',
                'image' => '/images/bunzing.webp',
                'beheerder' => 'Staatsbosbeheer',
            ],
        ];

        foreach ($speciesData as $specie) {
            // Find or create habitat dynamically
            $habitat = Habitat::firstOrCreate(['name' => $specie['habitat_name']]);

            Specie::updateOrCreate(
                ['name' => $specie['name']],
                [
                    'scientific_name' => $specie['scientific_name'],
                    'habitat_id' => $habitat->id,
                    'info' => $specie['info'],
                    'image' => $specie['image'],
                    'beheerder' => $specie['beheerder'],
                    'status' => $animal['nullable'] ?? 1,
                ]
            );
        }
    }
}
