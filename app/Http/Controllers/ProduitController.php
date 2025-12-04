<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Panier;

use App\Models\Livraison;

class ProduitController extends Controller
{
    /**
     * Affiche la page d'accueil avec tous les produits
     */

    public function show($slug)
    {
        $produit = Produit::with(['images', 'mainImage', 'attributvaleurs.attribut'])
            ->where('slug', $slug)
            ->firstOrFail();

        $produit_gallery = $produit->images()->where('is_main', 0)->get();


        $categories = Categorie::with([
            'produits',
            'children',
            'children.produits',
            'children.children',
            'children.children.produits'
        ])->whereNull('parent_id')->get();

        // Récupérer la liste existante ou créer une liste vide
        $recent = session()->get('recently_viewed', []);

        // Si l'ID existe déjà, le retirer pour le mettre en tête
        $recent = array_diff($recent, [$produit->id]);

        // Ajouter en tête (produit le plus récent)
        array_unshift($recent, $produit->id);

        // Garder uniquement les 10 derniers
        $recent = array_slice($recent, 0, 8);


        // Sauvegarde
        session()->put('recently_viewed', $recent);
        if (Auth::check()) {
            // Total des produits uniquement pour l'utilisateur connecté
            $totalProducts = Panier::where('user_id', Auth::id())->sum('quantity');
        } else {
            // Si personne n'est connecté
            $totalProducts = '';
        }
        $livraisons = Livraison::all();
        $relatedProducts = Produit::where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->take(4)
            ->get();
        $produit_gallery = $produit->images()->where('is_main', 0)->get();
        // debug rapide (supprime ensuite)
        return view('produits.show', compact('produit', 'totalProducts', 'produit_gallery', 'relatedProducts', 'livraisons', 'categories'));
    }

    public function index()
    {
        // Récupération de tous les produits (avec leur catégorie associée)
        $produits = Produit::with('categorie')->latest()->get();

        $categories = Categorie::with('produits')->whereNull('parent_id')->get();

        $newProducts = Produit::orderBy('created_at', 'desc')->take(4)->get();

        $recentIds = session('recently_viewed', []);
        $recentIds = array_slice($recentIds, 0, 8);
        $recentlyViewed = collect(); // valeur par défaut

        if (!empty($recentIds)) {
            $idsString = implode(',', $recentIds);

            $recentlyViewed = Produit::whereIn('id', $recentIds)
                ->orderByRaw("FIELD(id, $idsString)")
                ->get();
        }


        if (Auth::check()) {
            // Total des produits uniquement pour l'utilisateur connecté
            $totalProducts = Panier::where('user_id', Auth::id())->sum('quantity');
        } else {
            // Si personne n'est connecté
            $totalProducts = '';
        }
        // Envoi à la vue "index.blade.php"

        return view('index', compact('produits', 'totalProducts', 'categories', 'newProducts', 'recentlyViewed'));
    }
    /** 
     * Formulaire d'ajout de produit
     */
    public function create()
    {
        $categories = Categorie::with('produits')->whereNull('parent_id')->get();
        $totalProducts = Auth::check() ? Panier::where('user_id', Auth::id())->sum('quantity') : 0;
        return view('produits.create', compact('categories', 'totalProducts'));
    }

    // Enregistrement du produit
    public function store(Request $request)
    {

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8120',
            'badge' => 'nullable|string|max:255',
            'specs' => 'nullable|array',
            'specs.*.key' => 'nullable|string|max:255',
            'specs.*.value' => 'nullable|string|max:255',
            'attributs' => 'nullable|array',
            'attributs.*.attribut_valeur_id' => 'nullable|integer|exists:attribut_valeurs,id',
            'attributs.*.stock' => 'nullable|integer|min:0',
        ]);


        // Créer un slug unique
        $slug = Str::slug($validated['name']);
        $count = Produit::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) $slug .= '-' . ($count + 1);

        // Création du produit
        $produit = Produit::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'categorie_id' => $validated['categorie_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'badge' => $validated['badge'] ?? null,
        ]);

        // 🔧 Enregistrer les specs
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $produit->specs()->create([
                        'key' => $spec['key'],
                        'value' => $spec['value'],
                    ]);
                }
            }
        }

        // 📸 Enregistrer les images
        // 📸 Enregistrer les images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = time() . '-' . Str::slug($originalName) . '.' . $image->extension();
                $image->move(public_path('uploads'), $imageName);

                if ($key === 0) {
                    // Première image = image principale
                    $produit->images()->create([
                        'filename' => 'uploads/' . $imageName,
                        'is_main' => 1,
                    ]);

                    // Optionnel : stocker aussi dans la colonne img du produit
                    $produit->img = 'uploads/' . $imageName;
                    $produit->save();
                } else {
                    $produit->images()->create([
                        'filename' => 'uploads/' . $imageName,
                        'is_main' => 0,
                    ]);
                }
            }
        }

        // 🔗 Enregistrer les attributs avec stock
        // Filtrer uniquement les attributs valides
        $attributs = [];
        if (!empty($validated['attributs']) && is_array($validated['attributs'])) {
            $attributs = array_filter($validated['attributs'], function ($attr) {
                return !empty($attr['attribut_valeur_id']);
            });
        }

        // Préparer les données pour sync
        $valeurs_stock = [];
        foreach ($attributs as $attr) {
            $valeurs_stock[$attr['attribut_valeur_id']] = ['stock' => $attr['stock'] ?? 0];
        }
        $produit->attributvaleurs()->sync($valeurs_stock);

        return redirect()->route('produits.create')->with('success', 'Produit ajouté avec succès ✅');
    }
    public function showAll(Request $request)
    {
        $query = $request->input('q');

        // Panier
        $totalProducts = Auth::check()
            ? Panier::where('user_id', Auth::id())->sum('quantity')
            : '';

        // Catégories
        $categories = Categorie::all();

        // BASE QUERY
        $produitsQuery = Produit::with('categorie');

        // 🔍 Si recherche → filtrer
        if ($query) {
            $produitsQuery->where(function ($q2) use ($query) {
                $q2->where('name', 'LIKE', "%$query%")
                    ->orWhereHas('categorie', function ($cat) use ($query) {
                        $cat->where('name', 'LIKE', "%$query%");
                    });
            });
        } else {
            // 🔥 Si pas de recherche → comportement e-commerce
            $produitsQuery
                ->orderByDesc('sales_count')  // populaires en premier
                ->inRandomOrder();           // mélange léger
        }

        // Pagination
        $produits = $produitsQuery->paginate(10);

        return view('produits.index', compact('produits', 'totalProducts', 'categories', 'query'));
    }
}
