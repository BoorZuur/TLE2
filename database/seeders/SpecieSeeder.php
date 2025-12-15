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
            // Veluwe
            ['name' => 'Haas', 'scientific_name' => 'Lepus europaeus', 'habitat_name' => 'Veluwe', 'info' => 'Hupsend over heide en grasland.', 'image' => '/images/store_animals/hare-standing.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Wild zwijn', 'scientific_name' => 'Sus scrofa', 'habitat_name' => 'Veluwe', 'info' => 'Krachtig zwijn in bossen.', 'image' => '/images/store_animals/boar.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Edelhert', 'scientific_name' => 'Cervus elaphus', 'habitat_name' => 'Veluwe', 'info' => 'Majestueus hert in de Veluwe.', 'image' => '/images/store_animals/deer-standing.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Wolf', 'scientific_name' => 'Canis lupus', 'habitat_name' => 'Veluwe', 'info' => 'Sporadisch roofdier.', 'image' => '/images/store_animals/wolf-sitting.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Vos', 'scientific_name' => 'Vulpes vulpes', 'habitat_name' => 'Veluwe', 'info' => 'Weinig dieren zijn zo mysterieus en veelzijdig als de vos. Met zijn slimme ogen, sluwe snuit en zachte, rode vacht is hij gemaakt om te sluipen door bossen en graslanden.', 'image' => '/images/store_animals/fox-standing.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Otter', 'scientific_name' => 'Lutra lutra', 'habitat_name' => 'Veluwe', 'info' => 'Weinig dieren zijn zo kenmerkend voor ons waterrijke land als de otter. Met zijn wendbare lichaam en waterdichte vacht is hij gemaakt om te jagen in het water.', 'image' => '/images/store_animals/otter-standing.png', 'beheerder' => 'Natuurmonumenten'],

            // Tiengemeenten
            ['name' => 'Bever', 'scientific_name' => 'Castor fiber', 'habitat_name' => 'Tiengemeenten', 'info' => 'Bouwt dammen in rivieren en beken.', 'image' => '/images/store_animals/beaver.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Bunzing', 'scientific_name' => 'Mustela putorius', 'habitat_name' => 'Tiengemeenten', 'info' => 'Zeldzaam dier langs water.', 'image' => '/images/store_animals/polecat.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Kikker', 'scientific_name' => 'Rana temporaria', 'habitat_name' => 'Tiengemeenten', 'info' => 'Weinig dieren zijn zo vertrouwd en veelzijdig als de kikker. Met zijn glibberige huid, sterke achterpoten en grote ogen is hij gemaakt om te springen, zwemmen en jagen op insecten in vijvers, sloten en plassen.', 'image' => '/images/store_animals/frog-standing.png', 'beheerder' => 'Natuurmonumenten'],

            // ENCI-Groeve
            ['name' => 'Oehoe', 'scientific_name' => 'Bubo bubo', 'habitat_name' => 'ENCI-Groeve', 'info' => 'Broedt in steile kalkwanden.', 'image' => '/images/store_animals/owl-sitting.png', 'beheerder' => 'Natuurmonumenten'],

            // Waddeneilanden
            ['name' => 'Zeehond', 'scientific_name' => 'Phoca vitulina', 'habitat_name' => 'Waddeneilanden', 'info' => 'Rust op zandplaten en duinen.', 'image' => '/images/store_animals/seal.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Ijsvogel', 'scientific_name' => 'Alcedo atthis', 'habitat_name' => 'Waddeneilanden', 'info' => 'Langs sloten en waterkanten.', 'image' => '/images/store_animals/kingfisher.png', 'beheerder' => 'Natuurmonumenten'],

            // Groene Hart
            ['name' => 'Grutto', 'scientific_name' => 'Limosa limosa', 'habitat_name' => 'Groene Hart', 'info' => 'Broedt in natte weilanden.', 'image' => '/images/store_animals/godwit.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Egel', 'scientific_name' => 'Erinaceus europaeus', 'habitat_name' => 'Groene Hart', 'info' => 'Bos- en graslandbewoner.', 'image' => '/images/store_animals/hedgehog.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Mol', 'scientific_name' => 'Talpa europaea', 'habitat_name' => 'Groene Hart', 'info' => 'Graaft gangen in grasland.', 'image' => '/images/store_animals/mol.png', 'beheerder' => 'Natuurmonumenten'],
            ['name' => 'Bij', 'scientific_name' => 'Apis mellifera', 'habitat_name' => 'Groene Hart', 'info' => 'Zoemt rond bloemrijke velden.', 'image' => '/images/store_animals/bee.png', 'beheerder' => 'Natuurmonumenten'],
        ];

        foreach ($speciesData as $specie) {
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
