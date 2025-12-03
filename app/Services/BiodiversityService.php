<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiodiversityService
{
    protected $baseUrl = 'https://api.biodiversitydata.nl/v2';

    /**
     * Haal specimens op binnen een gebied (geo‑area id of locality)
     */
    public function getAnimalsInArea($areaIdentifier, $limit = 15)
    {
        $response = Http::post("{$this->baseUrl}/specimen/query/", [
            'conditions' => [
                [
                    'field' => 'gatheringEvent.siteCoordinates.geoShape',
                    'operator' => 'IN',
                    'value' => $areaIdentifier
                ],
                [
                    'field' => 'identifications.defaultClassification.kingdom',
                    'operator' => 'EQUALS',
                    'value' => 'Animalia'
                ]
            ],
            'size' => $limit
        ]);

        if ($response->failed()) {
            \Log::error('NBA specimen query failed for area ' . $areaIdentifier . ': ' . $response->body());
            return [];
        }

        return $response->json()['data'] ?? [];
    }

    /**
     * Haal de geo‑area id(s) op voor een gegeven locality naam
     */
    public function getGeoAreaIdsByLocality(string $localityName, string $areaType = 'Nature', int $max = 5): array
    {
        $query = [
            'areaType' => $areaType,
            'locality' => $localityName,
            '_size' => $max,
        ];

        $response = Http::get("{$this->baseUrl}/geo/query/", $query);

        if ($response->failed()) {
            \Log::error('NBA geo query failed for locality ' . $localityName . ': ' . $response->body());
            return [];
        }

        $json = $response->json();
        $records = $json['data'] ?? [];

        $ids = [];
        foreach ($records as $rec) {
            if (isset($rec['id'])) {
                $ids[] = $rec['id'];
            }
        }

        \Log::info("Geo IDs for {$localityName}: " . json_encode($ids));
        return $ids;
    }

    /**
     * Haal dieren op voor meerdere lokaliteiten / gebieden
     */
    public function getAnimalsForLocalities(array $localities, int $perArea = 15): array
    {
        $all = [];
        foreach ($localities as $loc) {
            $ids = $this->getGeoAreaIdsByLocality($loc);
            foreach ($ids as $id) {
                $animals = $this->getAnimalsInArea($id, $perArea);
                if (!empty($animals)) {
                    $all = array_merge($all, $animals);
                }
            }
        }
        return $all;
    }
}


