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
        // seed products - animals and powerups
        $products = [
            // Animals with coins
            [
                'name' => 'Konijn',
                'description' => 'Een schattig konijn dat graag huppelt. Perfect voor beginners!',
                'image_url' => '/images/cheerful-fox.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_tag' => 1,
            ],
            [
                'name' => 'Eend',
                'description' => 'Een vrolijke eend die graag zwemt. Makkelijk te verzorgen.',
                'image_url' => '/images/eend.jpg',
                'price' => 150,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_tag' => 2,
            ],
            [
                'name' => 'Vos',
                'description' => 'Een slimme en speelse vos. Vereist wat meer aandacht.',
                'image_url' => '/images/cheerful-fox.png',
                'price' => 250,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_tag' => 3,
            ],
            // Premium animals with real money
            [
                'name' => 'Edelhert',
                'description' => 'Een majestueus edelhert. Exclusief en zeldzaam!',
                'image_url' => '/images/edelhert.avif',
                'price' => 4.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_tag' => 4,
            ],
            [
                'name' => 'Boomkikker',
                'description' => 'Een zeldzame boomkikker met prachtige kleuren. Limited edition!',
                'image_url' => '/images/boomkikker.avif',
                'price' => 3.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_tag' => 5,
            ],
            // Powerups with coins
            [
                'name' => 'Dubbele Munten',
                'description' => 'Verdien 2x zoveel munten voor 1 uur!',
                'image_url' => '/images/food.png',
                'price' => 50,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => ['Dubbele munten voor 1 uur', 'Stapelbaar met andere bonussen'],
            ],
            [
                'name' => 'Auto-Voeding',
                'description' => 'Je dieren worden automatisch gevoerd voor 24 uur!',
                'image_url' => '/images/food.png',
                'price' => 75,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => ['Automatisch voeden voor 24 uur', 'Werkt voor alle dieren'],
            ],
            [
                'name' => 'Geluk Booster',
                'description' => 'Verhoog je geluk en vind zeldzame items!',
                'image_url' => '/images/food.png',
                'price' => 100,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => ['10% meer kans op zeldzame items', 'Duurt 12 uur'],
            ],
            // Premium powerups with real money
            [
                'name' => 'VIP Pakket',
                'description' => 'Krijg toegang tot exclusive features en extra munten!',
                'image_url' => '/images/food.png',
                'price' => 9.99,
                'product_type' => 'powerup',
                'currency_type' => 'real_money',
                'powerup_effects' => ['500 bonus munten', 'Toegang tot VIP gebied', '5x snellere groei', 'Permanent actief'],
            ],
            [
                'name' => 'Mega Booster',
                'description' => 'De ultieme powerup voor serieuze spelers!',
                'image_url' => '/images/food.png',
                'price' => 14.99,
                'product_type' => 'powerup',
                'currency_type' => 'real_money',
                'powerup_effects' => ['1000 bonus munten', '3x sneller munten verdienen', 'Alle dieren altijd gelukkig', '30 dagen actief'],
            ],
            // QR-code dieren
            [
                'name' => 'Bunzing',
                'description' => 'Een zeldzaam dier met een knuffelig uiterlijk. Alleen op te halen bij een bezoekerscentrum van natuurmonumenten!',
                'image_url' => '/images/bunzing.webp',
                'price' => 0,
                'product_type' => 'animal',
                'currency_type' => 'qr',
                'species_tag' => 6,
                'qr_filename' => 'tiengemeenten.png',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
