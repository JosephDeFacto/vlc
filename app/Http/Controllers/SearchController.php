<?php

namespace App\Http\Controllers;

use App\Service\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;

    }
    public function search(Request $request)
    {
        $query = $request->input('q');

        $cacheKey = $query;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $validator = Validator::make(['q' => $query], [
            'q' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '"q" param is required'], 404);
        }

        $filteredResults = $this->apiService->makeRequest($query);

        Cache::put($cacheKey, response()->json($filteredResults), 60);

        return response()->json($filteredResults);
    }
}
