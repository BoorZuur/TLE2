<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed habitats
        $habitats = [
            ['name' => 'Bos'],
            ['name' => 'Duinen'],
        ];

        foreach ($habitats as $habitat) {
            \App\Models\Habitat::create($habitat);
        }
    }
}
