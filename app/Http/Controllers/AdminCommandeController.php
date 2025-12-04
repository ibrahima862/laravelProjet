<?php

namespace App\Http\Controllers;

use App\Notifications\CommandeStatusUpdated;
use App\Models\Commande;
use Illuminate\Http\Request;

class AdminCommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('user')->latest()->paginate(15);

        return view('admin.commandes.index', compact('commandes'));
    }

    public function show($id)
{
    $commande = Commande::with('articles.produit.attributvaleurs.attribut')->findOrFail($id);

    return view('admin.commandes.show', compact('commande'));
}
public function updateStatus(Request $request, $id)
{
    $commande = Commande::findOrFail($id);

    $request->validate([
        'status' => 'required|in:pending,confirmed,processing,preparing,shipped,delivered,cancelled',
    ]);

    $commande->status = $request->status;
    $commande->save();

    // ✅ Envoyer la notification automatiquement au client
    if ($commande->user) {
        $commande->user->notify(new \App\Notifications\CommandeStatusUpdated($commande));
    }

    return redirect()->back()->with('success', 'Statut de la commande mis à jour et notification envoyée.');
}


}
