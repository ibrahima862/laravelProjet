@extends('layouts.admin')

@section('content')
<div class="admin-dashboard-page">

    <!-- Header -->
    <div class="dashboard-header">
        <div>
            <h1>Commande #{{ $commande->id }}</h1>
            <p class="order-date">Créée le {{ $commande->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <span class="status-badge status-{{ strtolower($commande->status) }}">
            {{ ucfirst($commande->status) }}
        </span>
    </div>

    <!-- Grid -->
    <div class="grid-3">

        <!-- Carte Client -->
        <div class="card card-info">
            <h3>🧍 Client</h3>
            <p><strong>Nom :</strong> {{ $commande->name }}</p>
            <p><strong>Email :</strong> {{ $commande->email }}</p>
            <p><strong>Téléphone :</strong> {{ $commande->phone }}</p>
        </div>

        <!-- Carte Livraison -->
        <div class="card card-delivery">
            <h3>📦 Livraison</h3>
            <p><strong>Adresse :</strong> {{ $commande->address }}</p>
            <p><strong>Ville :</strong> {{ $commande->city }}</p>
        </div>

        <!-- Carte Total -->
        <div class="card card-total">
            <h3>💰 Total</h3>
            <p class="total-amount">{{ number_format($commande->total_amount,0) }} CFA</p>
        </div>
    </div>

    <!-- Timeline des statuts -->
    <div class="card card-timeline">
        <h3>🚦 Progression de la commande</h3>
        <ul class="timeline">
            @foreach(['pending','confirmed','processing','preparing','shipped','delivered','cancelled'] as $s)
                <li class="@if($commande->status == $s) active @elseif(array_search($s,['pending','confirmed','processing','preparing','shipped','delivered','cancelled']) < array_search($commande->status,['pending','confirmed','processing','preparing','shipped','delivered','cancelled'])) completed @endif">
                    {{ ucfirst($s) }}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Articles Commandés -->
    <div class="card card-articles">
        <h3>🛒 Articles</h3>
        <table class="articles-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Attribut</th>
                    <th>Prix</th>
                    <th>Qté</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->articles as $item)
                    @php
                        $pivotId = $item->produit_valeur_attribut_id;
                        $valeur = $item->produit->attributvaleurs->where('pivot.id', $pivotId)->first();
                    @endphp
                    <tr>
                        <td>{{ $item->produit->name }}</td>
                        <td>@if($valeur) {{ $valeur->attribut->name }} : {{ $valeur->value }} @else - @endif</td>
                        <td>{{ number_format($item->price,0) }} CFA</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity,0) }} CFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modifier le statut -->
    <div class="card status-card">
        <h3>🔧 Modifier le Statut</h3>
        <form action="{{ route('admin.commandes.updateStatus', $commande->id) }}" method="POST" class="status-form">
            @csrf
            @method('PUT')
            <select name="status" class="status-select">
                @foreach(['pending','confirmed','processing','preparing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @if($commande->status == $s) selected @endif>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="btn-update">Mettre à jour</button>
        </form>
    </div>

</div>

<style>
/* ================== PAGE ================== */
.admin-dashboard-page {
    font-family: 'Inter', sans-serif;
    background: #f4f6f9;
    padding: 30px;
    color: #1f2937;
}

/* ================== HEADER ================== */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(90deg,#5d00f4,#5200a9);
    color: #fff;
    padding: 20px 25px;
    border-radius: 16px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.dashboard-header h1 { font-size: 28px; font-weight: 700; }
.order-date { font-size: 14px; opacity: 0.85; }
.status-badge {
    padding: 8px 20px;
    border-radius: 30px;
    font-weight: 600;
    text-transform: capitalize;
    box-shadow: 0 3px 12px rgba(0,0,0,0.25);
    transition: transform 0.2s;
}
.status-badge:hover { transform: scale(1.05); }

/* Status gradients premium */
.status-pending { background: linear-gradient(90deg,#fbbf24,#f59e0b); color: #fff; }
.status-confirmed { background: linear-gradient(90deg,#10b981,#3b82f6); color: #fff; }
.status-processing { background: linear-gradient(90deg,#6d28d9,#9333ea); color: #fff; }
.status-preparing { background: linear-gradient(90deg,#f97316,#f43f5e); color: #fff; }
.status-shipped { background: linear-gradient(90deg,#14b8a6,#06b6d4); color: #fff; }
.status-delivered { background: linear-gradient(90deg,#15803d,#16a34a); color: #fff; }
.status-cancelled { background: linear-gradient(90deg,#dc2626,#b91c1c); color: #fff; }

/* ================== GRID ================== */
.grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

/* ================== CARDS ================== */
.card {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 40px rgba(0,0,0,0.12);
}

.card h3 { font-size: 18px; font-weight: 700; color: #000000a0; margin-bottom: 15px;border-bottom: 1px solid rgb(210, 210, 210) }

.card p{
    border-bottom: 1px solid rgb(235, 235, 235);
    font-size: 15px
}
/* ================== TIMELINE ================== */
.card-timeline .timeline {
    display: flex;
    list-style: none;
    padding: 0;
    gap: 10px;
    justify-content: space-between;
    flex-wrap: wrap;
}

.timeline li {
    flex: 1;
    position: relative;
    text-align: center;
    padding: 10px;
    font-size: 14px;
    border-radius: 12px;
    background: #e9ecef;
    color: #000000;
    transition: all 0.3s;
}

.timeline li.completed { background: #7b2ff7; color: #fff; }
.timeline li.active { background: #56a903; color: #fff; font-weight: 600; }

/* ================== TABLE ================== */
.articles-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.articles-table th, .articles-table td { padding: 12px; border-bottom: 1px solid #e9ecef; text-align: left; }
.articles-table th { background: #f3f4f6; font-weight: 600; }
.articles-table tbody tr:nth-child(even) td { background: #f9fafb; }
.articles-table tr:hover td { background: #1e4bef32; }

/* ================== STATUS FORM ================== */
.status-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}
.status-select {
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    font-weight: 500;
    transition: all 0.3s;
}
.status-select:focus {
    outline: none;
    border-color: #7b2ff7;
    box-shadow: 0 0 0 3px rgba(110, 19, 255, 0.2);
}

/* ================== BUTTON ================== */
.btn-update {
    padding: 10px 22px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    background: linear-gradient(90deg,#1e07f1,#7b2ff7);
    color: #fff;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-update:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }

/* ================== TOTAL ================== */
.card-total { text-align: right; }
.total-amount {
    font-size: 36px;
    font-weight: 700;
    background: rgba(247,7,163,0.15);
    padding: 12px 20px;
    border-radius: 12px;
    display: inline-block;
}
</style>
@endsection
