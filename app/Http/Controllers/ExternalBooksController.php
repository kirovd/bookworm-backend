<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalBooksController extends Controller
{
    public function fetchBestSellers()
    {
        $apiKey = env('NYT_API_KEY');
        $response = Http::withOptions([
            'verify' => false, 
        ])->get("https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json", [
            'api-key' => $apiKey
        ]);

        if ($response->successful()) {
            return response()->json($response->json()['results']['books']);
        }

        Log::error('Failed to fetch best sellers', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return response()->json(['error' => 'Failed to fetch best sellers'], 500);
    }
}

