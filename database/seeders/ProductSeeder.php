<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Specie;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all species once
        $species = Specie::all()->keyBy('name'); // map by name for easy lookup

        $products = [
            [
                'name' => 'Konijn',
                'description' => 'Een schattig konijn...',
                'image_url' => '/images/konijn.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Konijn', // we will use this to lookup id
            ],
            [
                'name' => 'Eend',
                'description' => 'Een vrolijke eend...',
                'image_url' => '/images/eend.jpg',
                'price' => 150,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Eend',
            ],
            // ... other products
        ];

        foreach ($products as $product) {
            // If it’s an animal, replace species_name with species_id
            if (isset($product['species_name'])) {
                $specie = $species[$product['species_name']] ?? null;
                if ($specie) {
                    $product['species_id'] = $specie->id;
                } else {
                    $this->command->warn("Specie '{$product['species_name']}' not found!");
                    unset($product['species_id']); // avoid null id
                }
                unset($product['species_name']); // remove temp field
            }

            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
