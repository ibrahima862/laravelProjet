<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\Categorie;
class NotificationController extends Controller
{  
  public function index(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $viewType = $request->query('view', 'notifications'); // par défaut notifications

    $commandes = collect(); // valeur par défaut
    $commande = null;
    $notifications = collect();

    if($viewType === 'orders'){
        $commandes = $user->commandes()->latest()->paginate(10);
    }

    if($viewType === 'order-details'){
        $commande = $user->commandes()->findOrFail($request->query('commande_id'));
    }

    if($viewType === 'notifications'){
        $notifications = $user->notifications()->latest()->paginate(10);
    }
     $totalProducts = Panier::where('user_id', Auth::id())->sum('quantity');
    $categories = Categorie::all();

    return view('Notifications.index', compact('notifications', 'commandes', 'commande', 'viewType','categories','totalProducts'));
}


    // Marquer une notification comme lue
    public function markRead($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notif = $user->notifications()->findOrFail($id);
        $notif->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    // Marquer toutes les notifications comme lues
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
    
}
