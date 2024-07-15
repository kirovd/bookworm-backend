<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalBooksController extends Controller
{
    public function fetchBestSellers()
    {
        $apiKey = env('NYT_API_KEY', 'f89TaECqBgx5rDA5YqGnofnuykd8mCYD');
        if (!$apiKey) {
            Log::error('NYT API Key is missing');
            return response()->json(['error' => 'NYT API Key is missing'], 500);
        }

        $response = Http::withOptions([
            'verify' => false, // Bypass SSL verification
        ])->get("https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json", [
            'api-key' => $apiKey
        ]);

        if ($response->successful()) {
            $books = array_slice($response->json()['results']['books'], 0, 9); // Get the first 9 books

            // Add rating and price
            $booksWithDetails = [];
            foreach ($books as $index => $book) {
                $isbn = $book['primary_isbn13'];
                $googleBooksResponse = Http::withOptions([
                    'verify' => false // Bypass SSL verification for Google Books API
                ])->get("https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn&key=YOUR_GOOGLE_BOOKS_API_KEY");
                $bookDetails = $googleBooksResponse->json();

                if (isset($bookDetails['items'][0])) {
                    $googleBook = $bookDetails['items'][0]['volumeInfo'];
                    $book['rating'] = $googleBook['averageRating'] ?? null;
                    $book['price'] = $googleBook['saleInfo']['listPrice']['amount'] ?? null;
                }

                $book['book_id'] = $index + 1; // Assign a unique book_id
                $booksWithDetails[] = $book;
            }

            return response()->json($booksWithDetails);
        }

        Log::error('Failed to fetch best sellers', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return response()->json(['error' => 'Failed to fetch best sellers'], 500);
    }
}


