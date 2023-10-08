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

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $validator = Validator::make(['q' => $query], [
            'q' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 400,
                    'error' => 'Your input field is empty.']
                ],400);
        }

        $filteredResults = $this->apiService->makeRequest($query);

        if (isset($filteredResults[0]['show']['name'])) {
            $name = $filteredResults[0]['show']['name'];
            Cache::put($cacheKey, response()->json($name), 60);
            return response()->json($name);
        }
        return response()->json([
            'error' => [
                'code' => 404,
                'error' => 'No results found.']
        ],404);
    }
}
