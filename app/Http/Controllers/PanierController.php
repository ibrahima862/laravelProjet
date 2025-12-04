<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Livraison;
use App\Models\Produit;
use App\Models\Categorie;

class PanierController extends Controller
{
    /**
     * Ajouter ou mettre à jour un produit dans le panier
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|integer|exists:produits,id',
            'produit_valeur_attribut_id' => 'nullable|integer|exists:produit_valeur_attribut,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour ajouter au panier.'
            ], 401);
        }

        $produitValeurId = $validated['produit_valeur_attribut_id'] ?? null;

        // Chercher si le produit existe déjà
        $panier = Panier::where('user_id', $userId)
            ->where('produit_id', $validated['produit_id'])
            ->when($produitValeurId === null, function ($query) {
                $query->whereNull('produit_valeur_attribut_id');
            }, function ($query) use ($produitValeurId) {
                $query->where('produit_valeur_attribut_id', $produitValeurId);
            })
            ->first();

        if ($panier) {
            $panier->quantity += $validated['quantity'];
            $panier->save();
        } else {
            $panier = Panier::create([
                'user_id' => $userId,
                'produit_id' => $validated['produit_id'],
                'produit_valeur_attribut_id' => $produitValeurId,
                'quantity' => $validated['quantity'],
            ]);
        }

        // Recharger pour s'assurer que toutes les colonnes sont à jour
        $panier->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier avec succès.',
            'panier' => $panier
        ]);
    }

    /**
     * Retourner le nombre total d’articles du panier de l’utilisateur connecté
     */
    public function badge()
    {
        $userId = Auth::id();
        $totalProducts = $userId ? Panier::where('user_id', $userId)->sum('quantity') : 0;

        return response()->json(['total' => $totalProducts]);
    }

    /**
     * Afficher le panier de l’utilisateur
     */
    public function index()
    {
        $userId = Auth::id();

        if (!$userId) {
            return view('panier.item', [
                'items' => collect(),
                'totalProducts' => 0,
                'subtotal' => 0,
                'livraisons' => collect(),
                'freeShippingLimit' => 50000,
                'shippingCost' => 0,
                'similarProducts' => collect(),
                'categories' => collect()
            ]);
        }

        // Récupérer les articles du panier avec leurs relations
        $items = Panier::where('user_id', $userId)
            ->with('produit.categorie')
            ->get();

        $totalProducts = $items->sum('quantity');

        $subtotal = $items->sum(function ($item) {
            return ($item->produit->prixReduit() ?? $item->produit->price) * $item->quantity;
        });

        $categories = Categorie::all();
        $livraisons = Livraison::all();
        $freeShippingLimit = 50000;
        $shippingCost = $subtotal >= $freeShippingLimit ? 0 : $livraisons->first()->price ?? 0;

        // Produits similaires (même catégorie mais pas dans le panier)
        $categorieIds = $items->pluck('produit.categorie_id')->filter()->unique();
        $produitIdsDansPanier = $items->pluck('produit.id')->toArray();

        $similarProducts = Produit::whereIn('categorie_id', $categorieIds)
            ->whereNotIn('id', $produitIdsDansPanier)
            ->take(10)
            ->get();

        return view('panier.item', compact(
            'items',
            'totalProducts',
            'subtotal',
            'livraisons',
            'freeShippingLimit',
            'shippingCost',
            'similarProducts',
            'categories'
        ));
    }

    /**
     * Supprimer un ou plusieurs produits du panier
     */
    public function remove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:paniers,id',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour supprimer un article.'
            ], 401);
        }

        $deleted = Panier::where('user_id', $userId)
            ->whereIn('id', $request->ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "$deleted article(s) supprimé(s) avec succès."
        ]);
    }
}
