<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitat;

class HabitatSeeder extends Seeder
{
    public function run(): void
    {
        $habitats = [
            'Veluwe',
            'Tiengemeenten',
            'ENCI-Groeve',
            'Waddeneilanden',
            'Groene Hart',
        ];

        foreach ($habitats as $name) {
            Habitat::updateOrCreate(
                ['name' => $name],
                ['name' => $name] // ensures it exists or updates
            );
        }
    }
}
