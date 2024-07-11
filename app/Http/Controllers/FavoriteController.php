<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        // Fetch all favorites with their associated book details
        $favorites = Favorite::with('book')->get();
        return response()->json($favorites);
    }


    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $favorite = Favorite::firstOrCreate([
            'book_id' => $request->book_id,
        ]);

        return response()->json($favorite);
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('book_id', $id)->first();
        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
