<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class AttributController extends Controller
{
    public function getByCategorie($id)
{
    $categorie = Categorie::with('attributs.valeurs')->findOrFail($id);
    return response()->json($categorie->attributs);
}

}
