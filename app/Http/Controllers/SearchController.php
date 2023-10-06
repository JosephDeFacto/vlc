<?php

namespace App\Http\Controllers;

use App\Service\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

    protected ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $cacheKey = 'search_' . md5($query);

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            // If cached, return the cached data
            return Cache::get($cacheKey);
        }

        // If not cached, perform the search and cache the results
        $validator = Validator::make(['q' => $query], [
            'q' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '"q" param is required'], 400);
        }

        $filteredResults = $this->apiService->makeRequest($query);

        // Cache the results for future requests (e.g., cache for 1 hour)
        Cache::put($cacheKey, response()->json($filteredResults), 60);

        return response()->json($filteredResults);
    }

}