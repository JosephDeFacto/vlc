<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function makeRequest($query)
    {
        $url = $this->apiUrl . "?q=" . $query;
        $response = Http::get($url);
        $data = $response->json();

        return array_filter($data, function ($item) use ($query) {
            return strcasecmp($item['show']['name'], $query) === 0 && strtolower($item['show']['name']) === strtolower($query);
        });
    }
}
