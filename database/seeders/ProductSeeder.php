<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed products
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/2560px-Placeholder_view_vector.svg.png',
                'price' => 19.99,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for product 2',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/2560px-Placeholder_view_vector.svg.png',
                'price' => 29.99,
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for product 3',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/2560px-Placeholder_view_vector.svg.png',
                'price' => 39.99,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
