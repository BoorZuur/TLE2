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
                'image_0' => '/images/Gebieden/0/veluwe0-2.png',
                'image_20' => '/images/Gebieden/1/veluwe1.png',
                'image_40' => '/images/Gebieden/2/veluwe2.png',
                'image_60' => '/images/Gebieden/3/veluwe3.png',
                'image_80' => '/images/Gebieden/4/veluwe4.png',
                'image_100' => '/images/Gebieden/5/veluwe5.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Lauwersmeer',
                'description' => 'Een van de grootste stadsparken in Nederland! Ideaal om te wandelen, hardlopen of picknicken! Erg gezinsvriendelijk en daarnaast zijn er ook sportvoorzieningen. De beste plek om te zijn als je even de natuur in wil in Rotterdam!',
                'info_image' => '/images/Gebieden/Zuiderpark_Rotterdam.png',
                'image_0' => '/images/Gebieden/0/park0.png',
                'image_20' => '/images/Gebieden/1/park1.png',
                'image_40' => '/images/Gebieden/2/park2-2.png',
                'image_60' => '/images/Gebieden/3/park3.png',
                'image_80' => '/images/Gebieden/4/park4-2.png',
                'image_100' => '/images/Gebieden/5/park5-2.png',
            ],
            [
                'id' => 3,
                'name' => 'Weerribben-Wieden',
                'description' => 'Een groot waterrijk natuurgebied in Noord-Brabant! prachtige zoetwatergetijden, bekend vanwege de bever en diverse andere dieren, en daarnaast perfect om te kanoën, varen, wandelen of fietsen!',
                'info_image' => '/images/Gebieden/biesbosch.png',
                'image_0' => '/images/Gebieden/0/biesbosch0.png',
                'image_20' => '/images/Gebieden/1/biesbosch1.png',
                'image_40' => '/images/Gebieden/2/biesbosch2.png',
                'image_60' => '/images/Gebieden/3/biesbosch3.png',
                'image_80' => '/images/Gebieden/4/biesbosch4.png',
                'image_100' => '/images/Gebieden/5/biesbosch5.png',
            ],
            [
                'id' => 4,
                'name' => 'De Waddeneilanden',
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
                'name' => 'Speulderbos',
                'description' => 'Het Speulderbos is een van de meest Sfeervolle bossen in Nederland! Geleden in de Veluwe, De kronkelige bomen en scheefgegroeide bomen geven het bos een sprookjesachtige uitstraling! Ook is er een groot palette aan wildlife te vinden, zoals edelherten, zwijnen en vossen! Dit is het perfecte en allerbeste gebied voor een wandeltocht!',
                'info_image' => '/images/Gebieden/bos.png',
                'image_0' => '/images/Gebieden/0/speulderbos0.png',
                'image_20' => '/images/Gebieden/1/speulderbos1.png',
                'image_40' => '/images/Gebieden/2/speulderbos2.png',
                'image_60' => '/images/Gebieden/3/speulderbos3.png',
                'image_80' => '/images/Gebieden/4/speulderbos4.png',
                'image_100' => '/images/Gebieden/5/speulderbos5.png',
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
