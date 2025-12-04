<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        // Récupère tous les clients
        $clients = Clients::all();

        // Envoie les données à la vue
        return view('clients.index', compact('clients'));
    }
}
