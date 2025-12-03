<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed species
        $species = [
            ['name' => 'Vos', 'habitat_tag' => 1],
            ['name' => 'Das', 'habitat_tag' => 1],
            ['name' => 'Egel', 'habitat_tag' => 1],
            ['name' => 'Ree', 'habitat_tag' => 1],
            ['name' => 'Boomkikker', 'habitat_tag' => 1],
            ['name' => 'Adder', 'habitat_tag' => 1],
            ['name' => 'Schorpioen', 'habitat_tag' => 2],
            ['name' => 'Kleine vos', 'habitat_tag' => 2],
            ['name' => 'Duinparelmoervlinder', 'habitat_tag' => 2],
            ['name' => 'Zandhagedis', 'habitat_tag' => 2],
        ];

        foreach ($species as $specie) {
            \App\Models\Specie::create($specie);
        }
    }
}
