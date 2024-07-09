<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        return Favorite::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'exists:books,id',
            'user_id' => 'exists:users,id',
        ]);

        $favorite = new Favorite;
        $favorite->user_id = $request->user_id;
        $favorite->book_id = $request->book_id;
        $favorite->save();

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
