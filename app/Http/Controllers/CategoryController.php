<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategoryController extends Controller
{
  // CategoryController.php
  public function index()
  {
    $categories = Categorie::whereNull('parent_id')
      ->with('children') // charge les sous-catégories
      ->get();

    return view('categories.index', compact('categories'));
  }
}
