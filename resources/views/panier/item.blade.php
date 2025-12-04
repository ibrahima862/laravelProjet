@extends('layouts.app')
@section('title', 'Panier')
@section('css')
    @vite(['resources/css/item.css'])
@endsection
@section('js')
    @vite(['resources/js/item.js'])
@endsection

@section('content')
    <div class="items-container">
    <div class="cart-items" id="cartItems">
        <h1>Panier</h1>
        @foreach ($items as $item)
            @php
                $produit = $item->produit;
                $prixReduit = $produit->prixReduit();
                $prixFinal = $prixReduit ?? $produit->price;
                $totalProduit = $prixFinal * $item->quantity;
                $variant = $item->variant; // relation panier -> variant
            @endphp

            <div class="cart-item">

                <!-- IMAGE -->
                <div class="cart-item__image">
                    <img src="{{ asset($produit->img ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
                        alt="{{ $produit->name }}">
                    @if ($item->variation)
                        <p>
                            {{ $item->variation->attributValeur->attribut->name }} :
                            {{ $item->variation->attributValeur->value }}
                        </p>
                    @endif

                    @if ($produit->badge)
                        <span class="cart-item__badge">{{ $produit->badge }}</span>
                    @endif
                </div>

                <!-- CONTENT GLOBAL -->
                <div class="cart-item__content">
                    <div class="cart-item__top">
                        <div class="cart-item__info">
                            <h3 class="product-name">{{ $produit->name }}</h3>
                            @if ($variant)
                                <div class="product-attributes">
                                    @foreach ($variant->values as $val)
                                        <p>{{ $val->attribut->name }} : {{ $val->value }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <p class="product-description">{{ $produit->description }}</p>
                        </div>
                        <div class="cart-item__meta">
                            @if ($produit->stock > 0)
                                <span class="stock ok">en Stock</span>
                            @else
                                <span class="stock out">Rupture de Stock</span>
                            @endif
                        </div>

                    </div>

                    <div class="cart-item__bottom">

                        <div class="cart-item__prices">
                            @if ($prixReduit)
                                <span class="price--new">{{ number_format($prixReduit, 0, ',', ' ') }} FCFA</span>
                                <span class="price--old">{{ number_format($produit->price, 0, ',', ' ') }}
                                    FCFA</span>
                            @else
                                <span class="price--new">{{ number_format($produit->price, 0, ',', ' ') }}
                                    FCFA</span>
                            @endif

                        </div>
                        <div class="cart-item__actions">
                            <div class="quantity">
                                <button class="quantity__btn minus">-</button>
                                <input class="quantity__input" type="number" value="{{ $item->quantity }}">
                                <button class="quantity__btn plus">+</button>
                            </div>

                            <button class="btn-delete">Supprimer</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="cart-summary amazon-summary">

        <div class="summary-box">

            <h3 class="summary-title">Résumé de la commande</h3>

            <div class="summary-line">
                <span>Sous-total ({{ $totalProducts }} articles)</span>
                <span id="subtotal">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>

            <div class="summary-line">
                <span>Livraison</span>

                <select id="shippingSelect" class="amazon-select">
                    @foreach ($livraisons as $livraison)
                        <option value="{{ $livraison->price }}">
                            {{ $livraison->type }} — {{ number_format($livraison->price, 0, ',', ' ') }} FCFA
                            • {{ $livraison->estimated_days }} jours
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="summary-line">
                <span>Frais de livraison</span>
                <span id="shippingCost">
                    @if ($livraisons->isNotEmpty())
                        {{ number_format($livraisons->first()->price, 0, ',', ' ') }} FCFA
                    @else
                        0 FCFA
                    @endif
                </span>

            </div>

            {{-- Message livraison gratuite --}}
            <p id="freeShippingMessage" class="amazon-free">
                @if ($subtotal >= $freeShippingLimit)
                    Livraison GRATUITE activée 🎉
                @else
                    Dépensez encore <b>{{ number_format($freeShippingLimit - $subtotal, 0, ',', ' ') }} FCFA</b>
                    pour obtenir la <b>livraison GRATUITE</b>
                @endif
            </p>

            <hr class="amazon-divider">

            <div class="summary-line total">
                <span class="total-label">Montant total</span>
                <span id="total">
                    @if ($livraisons->isNotEmpty())
                        {{ number_format($subtotal + $livraisons->first()->price, 0, ',', ' ') }} FCFA
                    @else
                        {{ number_format($subtotal, 0, ',', ' ') }} FCFA
                    @endif
                </span>
            </div>

            <button id="checkoutBtn">Passer la commande</button>
        </div>
    </div>
    </div>
    <div class="checkout-overlay" id="checkoutOverlay"></div>

    <div class="checkout-modal" id="checkoutModal">
        <h2>Informations de livraison</h2>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nom complet" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Téléphone" required>
            <input type="text" name="address" placeholder="Adresse" required>
            <input type="text" name="city" placeholder="Ville" required>

            <select name=" payment_method">
                <option value="cod">Paiement à la livraison</option>
                <option value="online">Paiement en ligne</option>
            </select>

            <button type="submit" class="confirm-btn">Confirmer la commande</button>
        </form>
    </div>

    <script>
        const FREE_LIMIT = {{ $freeShippingLimit }};
    </script>
    </div>
    <section class="similar-products">
        <h3>Produits similaires</h3>
        <div class="similar-list">

            @foreach ($similarProducts as $produit)
                <div class="similar-item">

                    <div class="similar-image">
                        <img src="{{ asset($produit->img ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
                            alt="{{ $produit->name }}">
                    </div>

                    <div class="similar-info">
                        <h4>{{ $produit->name }}</h4>
                        <p class="price">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</p>

                        <a href="{{ route('produit.show', $produit->slug) }}" class="btn">
                            Voir le produit
                        </a>
                    </div>

                </div>
            @endforeach

        </div>
    </section>
@endsection
