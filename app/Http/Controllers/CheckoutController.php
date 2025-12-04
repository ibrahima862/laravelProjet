<?php

namespace App\Http\Controllers;

use App\Models\Article_commande;
use App\Models\Commande;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:30',
            'email'    => 'required|email|max:255',
            'city'     => 'required|string|max:255',
            'payment_method' => 'required|in:cod,online',
            'address'  => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        // Récupérer le panier avec la valeur d'attribut
        $panierItems = Panier::where('user_id', $userId)
            ->with(['produit', 'variation'])
            ->get();

        if ($panierItems->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // Calculer le total
        $total = $panierItems->sum(function ($item) {
            return $item->produit->price * $item->quantity;
        });

        // Créer la commande
        $commande = Commande::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'payment_method' => $validated['payment_method'],
            'address' => $validated['address'],
            'total_amount' => $total,
        ]);

        // Enregistrer les articles
        foreach ($panierItems as $item) {
            Article_commande::create([
                'commande_id' => $commande->id,
                'produit_id'  => $item->produit_id,
                'produit_valeur_attribut_id' => $item->produit_valeur_attribut_id,
                'quantity'    => $item->quantity,
                'price'       => $item->produit->price,
            ]);

            // Décrémenter le stock global
            $item->produit->decrement('stock', $item->quantity);

            // Décrémenter le stock spécifique à la valeur d'attribut
            if ($item->produit_valeur_attribut_id) {
                $pivot = $item->produit->attributvaleurs()
                    ->where('produit_valeur_attribut.id', $item->produit_valeur_attribut_id)
                    ->first()
                    ->pivot;

                if ($pivot) {
                    $pivot->stock -= $item->quantity;
                    $pivot->save();
                }
            }
        }

        // Vider le panier
        Panier::where('user_id', $userId)->delete();

       return redirect()->route('checkout.success', ['id' => $commande->id]);

    }
    public function success($id)
{
    $commande = Commande::with('articles')->findOrFail($id);
    return view('checkout.success', compact('commande'));
}

}
