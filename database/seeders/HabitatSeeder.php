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
                'info_image' => '/images/Gebieden/veluwe.png',
                'image_0' => '/images/Gebieden/0/veluwe0.png',
                'image_20' => '/images/Gebieden/1/veluwe1.png',
                'image_40' => '/images/Gebieden/2/veluwe2.png',
                'image_60' => '/images/Gebieden/3/veluwe3.png',
                'image_80' => '/images/Gebieden/4/veluwe4.png',
                'image_100' => '/images/Gebieden/5/veluwe5.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Tiengemeenten',
                'description' => 'In de haven van Tiengemeten stappen dagelijks wandelaars van de pont. Hun doel: het eiland ontdekken in één dag. Maar dat is eigenlijk te kort. Er valt hier zoveel te zien en te beleven. Je loopt van een nostalgisch platteland zo de bloemrijke weides in en vandaar weer naar moerassige rietlanden. Zo dicht bij de grote stad Rotterdam vind je hier stilte en rust. En dan te bedenken dat dit natuureiland een aantal jaren geleden er nog volstrekt anders uitzag.',
                'info_image' => '/images/Gebieden/tiengemeenten.png',
                'image_0' => '/images/Gebieden/0/tiengemeenten0.png',
                'image_20' => '/images/Gebieden/1/tiengemeenten1.png',
                'image_40' => '/images/Gebieden/2/tiengemeenten2.png',
                'image_60' => '/images/Gebieden/3/tiengemeenten3.png',
                'image_80' => '/images/Gebieden/4/tiengemeenten4.png',
                'image_100' => '/images/Gebieden/5/tiengemeenten5.png',
            ],
            [
                'id' => 3,
                'name' => 'ENCI-Groeve',
                'description' => 'De Sint-Pietersberg is eigenlijk een heuvel, maar we noemen het een berg. Zo voelt het ook als je hier wandelt. Dit zuidelijkste stukje Nederland gelegen tussen Maastricht en België is haast on-Nederlands mooi. De zeldzame kalkhellingen en het unieke microklimaat maken het gebied tot een uniek vlinder-, oehoe-, vleermuis- en plantenparadijs. Op de kop van de berg ligt het Fort Sint Pieter, een indrukwekkend verdedigingswerk voor de stad Maastricht.',
                'info_image' => '/images/Gebieden/encigroeve.png',
                'image_0' => '/images/Gebieden/0/encigroeve0.png',
                'image_20' => '/images/Gebieden/1/encigroeve1.png',
                'image_40' => '/images/Gebieden/2/encigroeve2.png',
                'image_60' => '/images/Gebieden/3/encigroeve3.png',
                'image_80' => '/images/Gebieden/4/encigroeve4.png',
                'image_100' => '/images/Gebieden/5/encigroeve5.png',
            ],
            [
                'id' => 4,
                'name' => 'Waddeneilanden',
                'description' => 'Een rij aan eilanden in het Noorden van Nederland. De eilanden hebben brede & lange stranden. Ook is de Waddenzee goed te zien vanaf het eiland en bevat het eiland zeehonden, diverse vogelsoorten en unieke plantsoorten. Perfect voor een wandeltocht, strandactiviteiten of kamperen!',
                'info_image' => '/images/Gebieden/waaden.png',
                'image_0' => '/images/Gebieden/0/wadden0.png',
                'image_20' => '/images/Gebieden/1/wadden1.png',
                'image_40' => '/images/Gebieden/2/wadden2.png',
                'image_60' => '/images/Gebieden/3/wadden3.png',
                'image_80' => '/images/Gebieden/4/wadden4.png',
                'image_100' => '/images/Gebieden/5/wadden5.png',
            ],
            [
                'id' => 5,
                'name' => 'Groene Hart',
                'description' => 'Het Groene Hart is een centraal gelegen, relatief dunbevolkt veenweidegebied in Nederland, omgeven door de grote steden van de Randstad: Rotterdam, Den Haag, Leiden, Haarlem, Amsterdam en Utrecht. Het staat bekend om zijn uitgestrekte, groene landschappen en waterrijke natuurgebieden.',
                'info_image' => '/images/Gebieden/groenehart.png',
                'image_0' => '/images/Gebieden/0/groenehart0.png',
                'image_20' => '/images/Gebieden/1/groenehart1.png',
                'image_40' => '/images/Gebieden/2/groenehart2.png',
                'image_60' => '/images/Gebieden/3/groenehart3.png',
                'image_80' => '/images/Gebieden/4/groenehart4.png',
                'image_100' => '/images/Gebieden/5/groenehart5.png',
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
