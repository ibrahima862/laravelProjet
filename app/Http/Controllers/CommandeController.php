<?php

namespace App\Http\Controllers;
use App\Models\Panier;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
class CommandeController extends Controller
{
    /**
     * Afficher toutes les commandes de l'utilisateur connecté
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Commande[] $commandes */
            $commandes = $user->commandes()
                ->with('articles.produit') // charger les articles et leurs produits
                ->latest()                // trier par date décroissante
                ->get();
            
        $totalProducts = Panier::where('user_id', Auth::id())->sum('quantity');
    
        return view('commandes.index', compact('commandes','totalProducts'));
    }

    /**
     * Afficher les détails d'une commande spécifique
     */
    public function show($id)
    {
        $commande = Commande::with('articles.produit')
            ->findOrFail($id);
          // 🔢 Calcul du panier
    if (Auth::check()) {
        $totalProducts = Panier::where('user_id', Auth::id())->sum('quantity');
    } else {
        $totalProducts = '';
    }

        return view('commandes.show', compact('commande','totalProducts'));
    }
    public function cancel($id)
{
    $commande = Commande::findOrFail($id);

    if ($commande->status !== 'pending') {
        return back()->with('error', 'Cette commande ne peut plus être annulée.');
    }

    $commande->status = 'cancelled';
    $commande->save();

    return back()->with('success', 'La commande a été annulée avec succès.');
}

}
