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
            'Lauwersmeer',
            'Weerribben-Wieden',
        ];

        foreach ($habitats as $index => $name) {
            Habitat::updateOrCreate(
                ['id' => $index + 1],
                ['name' => $name]
            );
        }
    }
}
