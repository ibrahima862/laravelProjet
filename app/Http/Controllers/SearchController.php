<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class SearchController extends Controller
{
   public function suggestions(Request $request)
{
    $query = $request->input('q', '');
    if(strlen($query) < 2) {
        return response()->json([]);
    }

    $suggestions = Produit::where('name', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'name', 'price', 'img']); // <-- récupère les colonnes utiles

    return response()->json($suggestions);
}

}
