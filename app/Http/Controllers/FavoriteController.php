<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::all(['book_id', 'title', 'author', 'price', 'rating']);
        return response()->json($favorites);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|string',
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'nullable|numeric',
            'rating' => 'nullable|numeric'
        ]);

        $favorite = Favorite::updateOrCreate(
            ['book_id' => $request->book_id],
            $request->only(['title', 'author', 'price', 'rating'])
        );

        return response()->json($favorite);
    }

    public function update(Request $request, $id)
    {
        $favorite = Favorite::where('book_id', $id)->first();
        if ($favorite) {
            $request->validate([
                'price' => 'nullable|numeric',
                'rating' => 'nullable|numeric'
            ]);
            $favorite->update($request->only(['price', 'rating']));
            return response()->json($favorite);
        }
        return response()->json(['error' => 'Favorite not found'], 404);
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

