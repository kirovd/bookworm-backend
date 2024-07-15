<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     title="External Books API Documentation",
 *     version="1.0.0",
 *     description="API documentation for External Books API",
 *     @OA\Contact(
 *         email="kirovd@hotmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local server"
 * )
 */
class ExternalBooksController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/v1/external-books",
     *     tags={"External Books"},
     *     summary="Get list of best-selling books",
     *     description="Fetches the list of best-selling books from an external API",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="author", type="string"),
     *                 @OA\Property(property="price", type="number"),
     *                 @OA\Property(property="rating", type="number"),
     *                 @OA\Property(property="isbn", type="string"),
     *                 @OA\Property(property="description", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function fetchBestSellers()
    {
        $apiKey = env('NYT_API_KEY', 'f89TaECqBgx5rDA5YqGnofnuykd8mCYD');
        if (!$apiKey) {
            Log::error('NYT API Key is missing');
            return response()->json(['error' => 'NYT API Key is missing'], 500);
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json", [
            'api-key' => $apiKey
        ]);

        Log::info('NYT API Response', ['status' => $response->status(), 'body' => $response->body()]);

        if ($response->successful()) {
            $books = array_slice($response->json()['results']['books'], 0, 9);

            // Add rating and price
            $booksWithDetails = [];
            foreach ($books as $book) {
                $isbn = $book['primary_isbn13'];
                $googleBooksResponse = Http::withOptions([
                    'verify' => false
                ])->get("https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn&key=YOUR_GOOGLE_BOOKS_API_KEY");
                $bookDetails = $googleBooksResponse->json();

                if (isset($bookDetails['items'][0])) {
                    $googleBook = $bookDetails['items'][0]['volumeInfo'];
                    $book['rating'] = $googleBook['averageRating'] ?? null;
                    $book['price'] = $googleBook['saleInfo']['listPrice']['amount'] ?? null;
                }

                $booksWithDetails[] = $book;
            }

            Log::info('Successfully fetched best sellers with details');
            return response()->json($booksWithDetails);
        }

        Log::error('Failed to fetch best sellers', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return response()->json(['error' => 'Failed to fetch best sellers'], 500);
    }
}



