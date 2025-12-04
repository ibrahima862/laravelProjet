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
