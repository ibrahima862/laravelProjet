@extends('layouts.app')

@section('content')
<div class="orders-container">
    <h1>Vos commandes</h1>

    <div class="table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>#Commande</th>
                    <th>Date</th>
                    <th>Articles</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Timeline</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td>#{{ $commande->id }}</td>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $commande->articles->count() }}</td>
                    <td>
                        {{ number_format($commande->total_amount,0) }} CFA
                        <div class="mini-bar" style="width: {{ min($commande->total_amount / 1000, 100) }}%;"></div>
                    </td>
                    <td>
                        <span class="order-status-badge status-{{ strtolower($commande->status ?? 'pending') }}">
                            {{ ucfirst($commande->status ?? 'En attente') }}
                        </span>
                    </td>
                    <td class="timeline-cell">
                        <div class="timeline-compact">
                            @foreach(['pending','confirmed','processing','preparing','shipped','delivered','cancelled'] as $status)
                                <span class="step 
                                    @if($commande->status == $status) active
                                    @elseif(array_search($status,['pending','confirmed','processing','preparing','shipped','delivered','cancelled']) < array_search($commande->status,['pending','confirmed','processing','preparing','shipped','delivered','cancelled'])) completed @endif">
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('commandes.show', $commande->id) }}" class="btn-view-order">
                            <i class="fa fa-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-orders">Vous n’avez passé aucune commande pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

.orders-container {
    max-width: 1000px;
    margin: 50px auto;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
}

.orders-container h1 {
    text-align: center;
    font-size: 26px;
    margin-bottom: 30px;
    font-weight: 600;
    color: #2a2f2e
}

.table-container {
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.orders-table th {
    background: #f3f4f6;
    font-weight: 600;
    padding: 14px;
    text-align: left;
}

.orders-table td {
    padding: 14px;
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.orders-table tr:hover td {
    background: #eef2ff;
}

/* MINI BAR */
.mini-bar {
    height: 5px;
    background: linear-gradient(90deg,#7b2ff7,#f107a3);
    border-radius: 4px;
    margin-top: 4px;
}

/* STATUS BADGE */
.order-status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: capitalize;
    color: #fff;
}
.status-pending { background: #fbbf24;font-size: 10px }
.status-confirmed { background: #3b82f6;font-size: 10px }
.status-processing { background: #6b7280;font-size: 10px }
.status-preparing { background: #f97316;font-size: 10px }
.status-shipped { background: #14b8a6;font-size: 10px }
.status-delivered { background: #16a34a;font-size: 10px }
.status-cancelled { background: #ef4444;font-size: 10px }

/* TIMELINE COMPACT */
.timeline-compact {
    display: flex;
    gap: 4px;
}
.timeline-compact .step {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #e5e7eb;
}
.timeline-compact .step.completed { background: #2416e8; }
.timeline-compact .step.active { background: #04b52a; }

/* BUTTON */
.btn-view-order {
    background: linear-gradient(135deg,#2905cad4,#3b00fed7);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid rgb(108, 108, 108);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;

}
.btn-view-order:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(123,47,247,0.3);
}

/* NO ORDERS */
.no-orders {
    text-align: center;
    padding: 20px;
    color: #6b7280;
    font-size: 16px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .orders-table th, .orders-table td { padding: 10px; }
}
</style>
@endsection
