@extends('layouts.app')

@section('content')
    <div class="order-details-container">
        <h1>Détails de la commande #{{ $commande->id }}</h1>

        <!-- Résumé -->
        <div class="order-summary">
            <div class="summary-left">
                <p><strong>Nom :</strong> {{ $commande->name }}</p>
                <p><strong>Email :</strong> {{ $commande->email }}</p>
                <p><strong>Téléphone :</strong> {{ $commande->phone }}</p>
                <p><strong>Adresse :</strong> {{ $commande->address }}, {{ $commande->city }}</p>
            </div>
            <div class="summary-right">
                <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Méthode :</strong> {{ strtoupper($commande->payment_method) }}</p>
                <p><strong>Total :</strong> {{ number_format($commande->total_amount, 0) }} CFA</p>
                <p><strong>Statut :</strong>
                    <span class="order-status status-{{ strtolower($commande->status ?? 'pending') }}">
                        <i class="status-icon"></i> {{ ucfirst($commande->status ?? 'Pending') }}
                    </span>
                </p>
            </div>
        </div>


        <!-- Articles -->
        <h2>Articles</h2>
        <div class="articles-list">

            @foreach ($commande->articles as $index => $item)
                @php
                    // Récupération du pivot ID venant de la table article_commande
                    $pivotId = $item->produit_valeur_attribut_id;

                    // Trouver la valeur d’attribut correspondant EXACTEMENT à ce pivot
                    $valeur = $item->produit->attributvaleurs->where('pivot.id', $pivotId)->first();
                @endphp

                <div class="article-card">

                    <div class="article-header" data-index="{{ $index }}">
                        <span class="article-name">
                            <i class="fa fa-box"></i> {{ $item->produit->name }}
                        </span>
                        <span>{{ $item->quantity }} x {{ number_format($item->price, 0) }} CFA</span>
                        <span>Total : {{ number_format($item->price * $item->quantity, 0) }} CFA</span>
                        <span class="toggle-icon">+</span>
                    </div>

                    <div class="article-details" id="details-{{ $index }}">

                        <p><strong>Image :</strong></p>
                        <img src="{{ asset($item->produit->img ?? 'images/no-image.png') }}"
                            alt="{{ $item->produit->name }}" class="product-image">

                        <p>
                            <strong>Attribut :</strong>
                            @if ($valeur)
                                {{ $valeur->attribut->name }} : {{ $valeur->value }}
                            @else
                                -
                            @endif
                        </p>

                    </div>
                </div>
            @endforeach
            @if (in_array($commande->status, ['pending', 'confirmed']))
                <form action="{{ route('commandes.cancel', $commande->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-cancel">Annuler la commande</button>
                </form>
            @endif


        </div>

        <a href="{{ route('commandes.index') }}" class="btn-home"><i class="fa fa-arrow-left"></i> Retour aux commandes</a>
    </div>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

        .order-details-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 15px;
            font-family: 'Poppins', sans-serif;
        }

        .order-details-container h1 {
            text-align: center;
            font-size: 34px;
            margin-bottom: 25px;
            font-weight: 700;
            color: #222;
        }

        .order-summary {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            background: #f8faff;
            /* fond légèrement bleu clair */
            border-radius: 12px;
            padding: 25px 30px;
            gap: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            font-family: 'Poppins', sans-serif;
        }

        .summary-left {
            flex: 1 1 45%;
            min-width: 250px;
            border-right: 1px solid rgb(207, 207, 207);
        }

        .summary-left,
        .summary-right {
            flex: 1 1 45%;
            min-width: 250px;
        }

        .summary-left p,
        .summary-right p {
            margin: 8px 0;
            font-size: 15px;
            color: #333;
            border-bottom: 1px solid rgba(111, 111, 111, 0.199);
        }

        .order-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            text-transform: capitalize;
        }

        .status-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        /* couleurs selon statut */
        .status-pending .status-icon {
            background: #f0ad4e;
        }

        .status-livree .status-icon {
            background: #28a745;
        }

        .status-annulee .status-icon {
            background: #dc3545;
        }

        /* badges texte */
        .status-pending {
            background: #f0ad4e33;
            color: #f0ad4e;
        }

        .status-livree {
            background: #28a74533;
            color: #28a745;
        }

        .status-annulee {
            background: #dc354533;
            color: #dc3545;
        }

        @media(max-width:768px) {
            .order-summary {
                flex-direction: column;
            }

            .summary-left,
            .summary-right {
                flex: 1 1 100%;
            }
        }

        .articles-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .article-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s;
        }

        .article-header {
            background: #f5f5f5;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
        }

        .article-header:hover {
            background: #e8f0ff;
        }

        .toggle-icon {
            font-weight: bold;
            transition: transform 0.3s;
        }

        .article-details {
            display: none;
            padding: 12px 16px;
            background: #fff;
        }

        .product-image {
            max-width: 120px;
            margin-top: 8px;
            border-radius: 6px;
        }

        /* Bouton retour */
        .btn-home {
            display: inline-block;
            background: linear-gradient(135deg, #0066ff, #004bcc);
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-home i {
            margin-right: 6px;
        }

        .btn-home:hover {
            transform: scale(1.05);
        }

        /* Statuts badges */
        .order-status {
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 600;
            color: #9b0e0e;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pending .status-icon {
            background: #f0ad4e;
            /* orange comme en-attente */
        }

        .status-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-en-attente .status-icon,
        .status-pending .status-icon {
            background: #f0ad4e;
        }

        .status-livree .status-icon {
            background: #28a745;
        }

        .status-annulee .status-icon {
            background: #dc3545;
        }

        /* Responsive */
        @media(max-width:768px) {
            .order-summary {
                flex-direction: column;
            }
        }

        .cancel-btn {
            background: #ff3b30;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #d32f2f;
        }
    </style>

    
@endsection
