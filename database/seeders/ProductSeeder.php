<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Specie;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $species = Specie::all()->keyBy('name'); // species keyed op name

        $products = [
            // ----- Animals (Veluwe) -----
            [
                'name' => 'Haas',
                'description' => 'Een schattige haas die graag huppelt.',
                'image_url' => '/images/store_animals/hare-standing.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Haas',
            ],
            [
                'name' => 'Wild zwijn',
                'description' => 'Sterk zwijn dat in de bossen leeft.',
                'image_url' => '/images/store_animals/boar.png',
                'price' => 150,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Wild zwijn',
            ],
            [
                'name' => 'Edelhert',
                'description' => 'Majestueus hert in de Veluwe.',
                'image_url' => '/images/store_animals/deer-standing.png',
                'price' => 700,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Edelhert',
            ],
            [
                'name' => 'Wolf',
                'description' => 'Sporadisch roofdier.',
                'image_url' => '/images/store_animals/wolf-sitting.png',
                'price' => 1.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Wolf',
            ],
            [
                'name' => 'Vos',
                'description' => 'Sluw en mysterieus, sluipt door bossen.',
                'image_url' => '/images/store_animals/fox-standing.png',
                'price' => 300,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Vos',
            ],
            [
                'name' => 'Otter',
                'description' => 'Kenmerkend voor waterrijke gebieden, zwemt en jaagt in water.',
                'image_url' => '/images/store_animals/otter-standing.png',
                'price' => 400,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Otter',
            ],

            // Tiengemeenten
            [
                'name' => 'Bever',
                'description' => 'Bouwt dammen in rivieren.',
                'image_url' => '/images/store_animals/beaver.png',
                'price' => 0,
                'product_type' => 'animal',
                'currency_type' => 'qr',
                'species_name' => 'Bever',
            ],
            [
                'name' => 'Bunzing',
                'description' => 'Zeldzaam dier langs oevers en bosranden.',
                'image_url' => '/images/store_animals/polecat.png',
                'price' => 0.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Bunzing',
                'qr_filename' => 'tiengemeenten.png',
            ],
            [
                'name' => 'Kikker',
                'description' => 'Vertrouwd en veelzijdig, springt en jaagt op insecten.',
                'image_url' => '/images/store_animals/frog-standing.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Kikker',
            ],

            // ENCI-Groeve
            [
                'name' => 'Oehoe',
                'description' => 'Broedt in steile kalkwanden.',
                'image_url' => '/images/store_animals/owl-sitting.png',
                'price' => 0,
                'product_type' => 'animal',
                'currency_type' => 'qr',
                'species_name' => 'Oehoe',
            ],

            // Waddeneilanden
            [
                'name' => 'Zeehond',
                'description' => 'Rust op zandplaten en duinen.',
                'image_url' => '/images/store_animals/seal.png',
                'price' => 0.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Zeehond',
            ],
            [
                'name' => 'Ijsvogel',
                'description' => 'Langs sloten en waterkanten.',
                'image_url' => '/images/store_animals/kingfisher.png',
                'price' => 0.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Ijsvogel',
            ],

            // Groene Hart
            [
                'name' => 'Grutto',
                'description' => 'Broedt in natte weilanden.',
                'image_url' => '/images/store_animals/godwit.png',
                'price' => 0.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Grutto',
            ],
            [
                'name' => 'Egel',
                'description' => 'Bos- en graslandbewoner.',
                'image_url' => '/images/store_animals/hedgehog.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Egel',
            ],
            [
                'name' => 'Mol',
                'description' => 'Graaft gangen in grasland.',
                'image_url' => '/images/store_animals/mol.png',
                'price' => 100,
                'product_type' => 'animal',
                'currency_type' => 'coins',
                'species_name' => 'Mol',
            ],
            [
                'name' => 'Bij',
                'description' => 'Zoemt rond bloemrijke velden.',
                'image_url' => '/images/store_animals/bee.png',
                'price' => 0.99,
                'product_type' => 'animal',
                'currency_type' => 'real_money',
                'species_name' => 'Bij',
            ],

            // ----- Powerups -----
            [
                'name' => 'Dubbele Munten',
                'description' => 'Verdien 2x zoveel munten voor 1 uur!',
                'image_url' => '/images/food.png',
                'price' => 50,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => json_encode(['effect' => 'Dubbele munten voor 1 uur', 'stackable' => true]),
            ],
            [
                'name' => 'Auto-Voeding',
                'description' => 'Je dieren worden automatisch gevoerd voor 24 uur!',
                'image_url' => '/images/food.png',
                'price' => 75,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => json_encode(['effect' => 'Automatisch voeden voor 24 uur']),
            ],
            [
                'name' => 'Geluk Booster',
                'description' => 'Verhoog je geluk en vind zeldzame items!',
                'image_url' => '/images/food.png',
                'price' => 100,
                'product_type' => 'powerup',
                'currency_type' => 'coins',
                'powerup_effects' => json_encode(['effect' => '10% meer kans op zeldzame items']),
            ],
            [
                'name' => 'VIP Pakket',
                'description' => 'Krijg toegang tot exclusive features en extra munten!',
                'image_url' => '/images/food.png',
                'price' => 1.99,
                'product_type' => 'powerup',
                'currency_type' => 'real_money',
                'powerup_effects' => json_encode(['500 bonus munten', 'VIP toegang', '5x snellere groei']),
            ],
            [
                'name' => 'Mega Booster',
                'description' => 'De ultieme powerup voor serieuze spelers!',
                'image_url' => '/images/food.png',
                'price' => 2.99,
                'product_type' => 'powerup',
                'currency_type' => 'real_money',
                'powerup_effects' => json_encode(['1000 bonus munten', '3x sneller munten verdienen', 'Dieren altijd gelukkig']),
            ],
        ];

        foreach ($products as $product) {
            if (isset($product['species_name'])) {
                $speciesId = $species[$product['species_name']]->id ?? null;
                unset($product['species_name']);
                $product['species_id'] = $speciesId;
            }

            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
