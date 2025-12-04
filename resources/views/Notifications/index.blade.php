@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* --- GLOBAL LAYOUT --- */
        .notifications-wrapper {
            display: flex;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e6e6e6;
            padding: 15px 0;
            height: fit-content;
        }

        .sidebar h3 {
            font-size: 16px;
            font-weight: 700;
            padding: 15px 20px;
            margin-bottom: 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            font-size: 15px;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: 0.25s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #f7f7f7;
            border-left: 3px solid #ff6a00;
        }

        /* --- MAIN CONTENT --- */
        .content-area {
            flex: 1;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e6e6e6;
            padding: 20px 25px;
            max-height: 750px;
            overflow-y: scroll;
        }

        /* --- NOTIFICATIONS --- */
        .notif-card {
            border: 1px solid #e0e0e0;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #fafafa;
            transition: 0.25s;
        }

        .notif-card.new {
            border-left: 4px solid #ff6a00;
            background: #fff7ec;
        }

        .notif-card:hover {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .notif-time {
            font-size: 13px;
            color: #888;
            margin-top: 6px;
        }

        /* --- ORDERS LIST --- */
        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
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
        }

        .orders-table tr:hover td {
            background: #eef2ff;
        }

        .order-status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: capitalize;
            color: #fff;
            font-size: 10px;
        }
 .order-status {
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        color: #e7e7e7;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
        .status-pending {
            background: #fbbf24;
        }

        .status-confirmed {
            background: #3b82f6;
        }

        .status-processing {
            background: #6b7280;
        }

        .status-preparing {
            background: #f97316;
        }

        .status-shipped {
            background: #14b8a6;
        }

        .status-delivered {
            background: #16a34a;
        }

        .status-cancelled {
            background: #ef4444;
        }

        /* --- ORDER DETAILS --- */
        .order-details-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .order-summary {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            background: #f8faff;
            border-radius: 12px;
            padding: 25px 30px;
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-left {
            flex: 1 1 45%;
            min-width: 250px;
            border-right: 1px solid rgb(207, 207, 207);
        }

        .summary-right {
            flex: 1 1 45%;
            min-width: 250px;
        }

        .summary-left p,
        .summary-right p {
            margin: 8px 0;
            font-size: 15px;
            color: #333;
            border-bottom: 1px solid rgba(111, 111, 111, 0.2);
        }

        .article-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
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

        .article-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 6px 6px;
            background: #fff;
        }

        .product-image {
            max-width: 120px;
            margin-top: 8px;
            border-radius: 6px;
        }

        .toggle-icon {
            font-weight: bold;
            transition: transform 0.3s;
        }

        .btn-view-order,
        .btn-home,
        .cancel-btn {
            display: inline-block;
            font-weight: 500;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-view-order {
            background: #6f2dff;
            color: #fff;
        }

        .btn-view-order:hover {
            background: #4a20b8;
        }

        .btn-home {
            background: #0066ff;
            color: #fff;
            margin-top: 15px;
        }

        .btn-home:hover {
            transform: scale(1.05);
        }

        .cancel-btn {
            background: #ff3b30;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background: #d32f2f;
        }

        /* --- RESPONSIVE --- */
        @media(max-width:768px) {
            .notifications-wrapper {
                flex-direction: column;
            }

            .summary-left,
            .summary-right {
                flex: 1 1 100%;
                border-right: none;
            }
        }
        footer{
            display: none
        }
    </style>

    <div class="notifications-wrapper">

        <!-- SIDEBAR -->
        <div class="sidebar">
            <h3><i class="fa-solid fa-user"></i> Mon espace</h3>
            <a href="{{ route('account') }}?view=notifications" class="{{ $viewType === 'notifications' ? 'active' : '' }}"><i
                    class="fa-solid fa-envelope"></i> Messages</a>
            <a href="{{ route('account') }}?view=orders" class="{{ $viewType === 'orders' ? 'active' : '' }}"><i
                    class="fa-solid fa-bag-shopping"></i> Commandes</a>
            <a href="#"><i class="fa-solid fa-credit-card"></i> Paiement</a>
            <a href="#"><i class="fa-solid fa-heart"></i> Sauvegarde & Historique</a>
            <a href="#"><i class="fa-solid fa-truck-fast"></i> Logistiques</a>
            <a href="#"><i class="fa-solid fa-boxes-stacked"></i> Dropshipping</a>
            <h3 style="margin-top:20px;"><i class="fa-solid fa-gear"></i> Paramètres</h3>
            <a href="#"><i class="fa-solid fa-user-gear"></i> Account settings</a>
        </div>

        <!-- CONTENT AREA -->
        <div class="content-area">
            @if ($viewType === 'notifications')
                <h1>🔔 Mes notifications</h1>
                @forelse($notifications as $notif)
                    <div class="notif-card {{ $notif->read_at ? '' : 'new' }}">
                        <p>{{ $notif->data['message'] }}</p>
                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <p>Aucune notification pour le moment.</p>
                @endforelse
                {{ $notifications->links() }}
            @elseif($viewType === 'orders')
                <h1>📦 Mes commandes</h1>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>#Commande</th>
                            <th>Date</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                            <tr>
                                <td>#{{ $commande->id }}</td>
                                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $commande->articles->count() }}</td>
                                <td>{{ number_format($commande->total_amount, 0) }} CFA</td>
                                <td>
                                    <span
                                        class="order-status-badge status-{{ strtolower($commande->status ?? 'pending') }}">
                                        {{ ucfirst($commande->status ?? 'En attente') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('account', ['view' => 'order-details', 'commande_id' => $commande->id]) }}"
                                        class="btn-view-order"><i class="fa fa-eye"></i> Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-orders">Aucune commande passée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $commandes->links() }}
            @elseif($viewType === 'order-details')
                @include('Notifications.partials.order-details')
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const headers = document.querySelectorAll('.article-header');
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const index = header.dataset.index;
                    const details = document.getElementById('details-' + index);
                    const toggleIcon = header.querySelector('.toggle-icon');

                    if (details.style.maxHeight && details.style.maxHeight !== "0px") {
                        details.style.maxHeight = "0";
                        toggleIcon.textContent = '+';
                    } else {
                        details.style.maxHeight = details.scrollHeight + "px";
                        toggleIcon.textContent = '-';
                    }
                });
            });
        });
    </script>

@endsection
