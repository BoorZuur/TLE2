<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitat;

class HabitatSeeder extends Seeder
{
    public function run(): void
    {
        $habitats = [
            [
                'id' => 1,
                'name' => 'Veluwe',
                'description' => 'De Veluwe is het grootste natuurgebied in nederland! Gelegen in Gelderland (en een deel van utrecht). Dit natuurgebied is erg populair om te wandelen, fietsen of paardrijden. Ook zijn er wilde dieren te vinden zoals herten, wilde zwijnen en vossen!',
                'info_image' => '/images/Gebieden/veluwe/info.jpg',
                'image_0' => '/images/Gebieden/veluwe/0.png',
                'image_20' => '/images/Gebieden/veluwe/20.png',
                'image_40' => '/images/Gebieden/veluwe/40.png',
                'image_60' => '/images/Gebieden/veluwe/60.png',
                'image_80' => '/images/Gebieden/veluwe/80.png',
                'image_100' => '/images/Gebieden/veluwe/100.png',
            ],
            [
                'id' => 2,
                'name' => 'Tiengemeten',
                'description' => 'In de haven van Tiengemeten stappen dagelijks wandelaars van de pont. Hun doel: het eiland ontdekken in één dag. Maar dat is eigenlijk te kort. Er valt hier zoveel te zien en te beleven. Je loopt van een nostalgisch platteland zo de bloemrijke weides in en vandaar weer naar moerassige rietlanden. Zo dicht bij de grote stad Rotterdam vind je hier stilte en rust. En dan te bedenken dat dit natuureiland een aantal jaren geleden er nog volstrekt anders uitzag.',
                'info_image' => '/images/Gebieden/tiengemeten/info.jpg',
                'image_0' => '/images/Gebieden/tiengemeten/0.png',
                'image_20' => '/images/Gebieden/tiengemeten/20.png',
                'image_40' => '/images/Gebieden/tiengemeten/40.png',
                'image_60' => '/images/Gebieden/tiengemeten/60.png',
                'image_80' => '/images/Gebieden/tiengemeten/80.png',
                'image_100' => '/images/Gebieden/tiengemeten/100.png',
            ],
            [
                'id' => 3,
                'name' => 'ENCI-Groeve',
                'description' => 'De Sint-Pietersberg is eigenlijk een heuvel, maar we noemen het een berg. Zo voelt het ook als je hier wandelt. Dit zuidelijkste stukje Nederland gelegen tussen Maastricht en België is haast on-Nederlands mooi. De zeldzame kalkhellingen en het unieke microklimaat maken het gebied tot een uniek vlinder-, oehoe-, vleermuis- en plantenparadijs. Op de kop van de berg ligt het Fort Sint Pieter, een indrukwekkend verdedigingswerk voor de stad Maastricht.',
                'info_image' => '/images/Gebieden/encigroeve/info.jpg',
                'image_0' => '/images/Gebieden/encigroeve/0.png',
                'image_20' => '/images/Gebieden/encigroeve/20.png',
                'image_40' => '/images/Gebieden/encigroeve/40.png',
                'image_60' => '/images/Gebieden/encigroeve/60.png',
                'image_80' => '/images/Gebieden/encigroeve/80.png',
                'image_100' => '/images/Gebieden/encigroeve/100.png',
            ],
            [
                'id' => 4,
                'name' => 'Waddeneilanden',
                'description' => 'Een rij aan eilanden in het Noorden van Nederland. De eilanden hebben brede & lange stranden. Ook is de Waddenzee goed te zien vanaf het eiland en bevat het eiland zeehonden, diverse vogelsoorten en unieke plantsoorten. Perfect voor een wandeltocht, strandactiviteiten of kamperen!',
                'info_image' => '/images/Gebieden/wadden/info.jpg',
                'image_0' => '/images/Gebieden/wadden/0.png',
                'image_20' => '/images/Gebieden/wadden/20.png',
                'image_40' => '/images/Gebieden/wadden/40.png',
                'image_60' => '/images/Gebieden/wadden/60.png',
                'image_80' => '/images/Gebieden/wadden/80.png',
                'image_100' => '/images/Gebieden/wadden/100.png',
            ],
            [
                'id' => 5,
                'name' => 'Groene Hart',
                'description' => 'Het Groene Hart is een centraal gelegen, relatief dunbevolkt veenweidegebied in Nederland, omgeven door de grote steden van de Randstad: Rotterdam, Den Haag, Leiden, Haarlem, Amsterdam en Utrecht. Het staat bekend om zijn uitgestrekte, groene landschappen en waterrijke natuurgebieden.',
                'info_image' => '/images/Gebieden/groenehart/info.jpg',
                'image_0' => '/images/Gebieden/groenehart/0.png',
                'image_20' => '/images/Gebieden/groenehart/20.png',
                'image_40' => '/images/Gebieden/groenehart/40.png',
                'image_60' => '/images/Gebieden/groenehart/60.png',
                'image_80' => '/images/Gebieden/groenehart/80.png',
                'image_100' => '/images/Gebieden/groenehart/100.png',
            ],
        ];

        foreach ($habitats as $habitat) {
            Habitat::updateOrCreate(
                ['id' => $habitat['id']],
                $habitat
            );
        }
    }
}
