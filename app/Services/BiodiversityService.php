<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiodiversityService
{
    protected $baseUrl = 'https://api.biodiversitydata.nl/v2';

    public function getAnimalsInArea($areaId, $limit = 15)
    {
        $response = Http::post("{$this->baseUrl}/specimen/query/", [
            'conditions' => [
                [
                    'field' => 'gatheringEvent.siteCoordinates.geoShape',
                    'operator' => 'IN',
                    'value' => $areaId
                ],
                [
                    'field' => 'identifications.defaultClassification.kingdom',
                    'operator' => 'EQUALS',
                    'value' => 'Animalia'
                ]
            ],
            'size' => $limit
        ]);

        return $response->json()['data'] ?? [];
    }
}

