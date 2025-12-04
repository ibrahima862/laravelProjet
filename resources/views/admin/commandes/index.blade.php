@extends('layouts.admin')

@section('content')
<div class="admin-commandes-page">
    <div class="page-title">📦 Gestion des Commandes</div>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="commandes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $c)
                    <tr class="status-{{ strtolower($c->status) }}">
                        <td>#{{ $c->id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>
                            {{ number_format($c->total_amount, 0) }} CFA
                            <!-- Mini barre représentant le total -->
                            <div class="mini-bar" style="width: {{ min($c->total_amount / 1000, 100) }}%;"></div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.commandes.updateStatus', $c->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    @foreach (['pending', 'confirmed', 'processing', 'preparing', 'shipped', 'delivered', 'cancelled'] as $status)
                                        <option value="{{ $status }}" @if ($c->status == $status) selected @endif>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.commandes.show', $c->id) }}">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $commandes->links() }}
    </div>
</div>

<style>
.admin-commandes-page {
    padding: 30px;
    font-family: 'Inter', sans-serif;
    background: #f4f6f9;
    color: #1f2937;
}

/* TITRE */
.page-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #7b2ff7;
}

/* ALERTES */
.alert.success {
    background: #d1fae5;
    color: #065f46;
    padding: 12px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    animation: fadeIn 0.5s ease-in-out;
}

/* TABLEAU */
.table-container { overflow-x: auto; }

.commandes-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.commandes-table th {
    background: #f3f4f6;
    font-weight: 600;
    padding: 14px;
    text-align: left;
}

.commandes-table td {
    padding: 14px;
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    position: relative;
}

.commandes-table tr:hover td { background: #eef2ff; }

/* BADGES DE STATUT */
.status-select {
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #d1d5db;
    font-weight: 500;
    transition: all 0.3s;
}

.status-pending select { background: #fbbf24; color: #fff; }
.status-confirmed select { background: #3b82f6; color: #fff; }
.status-processing select { background: #6b7280; color: #fff; }
.status-preparing select { background: #f97316; color: #fff; }
.status-shipped select { background: #14b8a6; color: #fff; }
.status-delivered select { background: #16a34a; color: #fff; }
.status-cancelled select { background: #ef4444; color: #fff; }

/* MINI BARRE DE TOTAL */
.mini-bar {
    height: 5px;
    background: linear-gradient(90deg,#7b2ff7,#f107a3);
    border-radius: 4px;
    margin-top: 4px;
}

/* BUTTONS */
.btn {
    padding: 8px 18px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(90deg,#7b2ff7,#f107a3);
    color: #fff;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(123,47,247,0.3);
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.pagination a, .pagination span {
    padding: 6px 12px;
    margin: 0 3px;
    border-radius: 8px;
    text-decoration: none;
    color: #7b2ff7;
    font-weight: 500;
    transition: all 0.3s;
}

.pagination a:hover {
    background: #f3f4f6;
}

/* ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* COULEURS DES LIGNES SELON STATUT */
tr.status-pending td { background: #fffbea; }
tr.status-confirmed td { background: #e0f2fe; }
tr.status-processing td { background: #f3f4f6; }
tr.status-preparing td { background: #fff7ed; }
tr.status-shipped td { background: #d1fae5; }
tr.status-delivered td { background: #dcfce7; }
tr.status-cancelled td { background: #fee2e2; }

</style>
@endsection
