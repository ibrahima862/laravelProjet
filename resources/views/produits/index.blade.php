@extends('layouts.app')

@section('title', 'Accueil')
@section('css')
    @vite(['resources/css/products.css'])
@endsection
@section('css')
    @vite(['resources/js/index.js'])
@endsection


@section('content')
      <!-- PRODUCTS -->
                        <section id="products" class="products" aria-labelledby="produits-title">
                            <div class="section-head">
                                <h2 id="produits-title">Nos meilleures ventes</h2>
                            </div>
                            <div class="products-with-sidebar">
                                <!-- Conteneur avec fond clair -->
                                <div id="productsContainer" class="products-section">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" id="sortToggle">
                                            Trier : populaires ▾
                                        </button>
                                        <ul class="dropdown-menu" id="sortMenu">
                                            <li data-value="popular">Populaires</li>
                                            <li data-value="price-asc">Prix croissant</li>
                                            <li data-value="price-desc">Prix décroissant</li>
                                            <li data-value="new">Nouveautés</li>
                                            <li data-value="promo">Promotions</li>
                                        </ul>
                                    </div>
                                    <div id="grid" class="product-grid" aria-live="polite">
                                        @foreach ($produits as $produit)
                                            <div class="product-card dynamic-card view-product"
                                                data-slug="{{ $produit->slug }}"
                                                data-name="{{ strtolower($produit->name) }}"
                                                data-category="{{ strtolower($produit->categorie->name ?? '') }}">
                                                <div class="product-image image-slider"
                                                    data-images='@json($produit->images->pluck('filename'))'>
                                                    <img src="{{ asset($produit->img ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
                                                        class="active" alt="{{ $produit->name }}">

                                                    <button class="slider-btn left-btn">&#10094;</button>
                                                    <button class="slider-btn right-btn">&#10095;</button>

                                                    <div class="dots-container"></div>

                                                    @if ($produit->badge)
                                                        <span class="badge">{{ $produit->badge }}</span>
                                                    @endif
                                                </div>



                                                <div class="product-info">
                                                    <h3>{{ $produit->name }}</h3>

                                                    @php
                                                        // Si le badge contient un pourcentage (-20%, -10% etc.)
                                                        $reduction = 0;
                                                        if (preg_match('/-([0-9]+)%/', $produit->badge, $matches)) {
                                                            $reduction = (int) $matches[1];
                                                        }
                                                        $prixReduit =
                                                            $reduction > 0
                                                                ? $produit->price - ($produit->price * $reduction) / 100
                                                                : null;
                                                    @endphp

                                                    @if ($prixReduit)
                                                        <p class="price">
                                                            <span
                                                                class="old">{{ number_format($produit->price, 0, ',', ' ') }}
                                                                FCFA</span>
                                                            <span
                                                                class="new">{{ number_format($prixReduit, 0, ',', ' ') }}
                                                                FCFA</span>
                                                        </p>
                                                    @else
                                                        <p class="price">
                                                            {{ number_format($produit->price, 0, ',', ' ') }} FCFA</p>
                                                    @endif
                                                    <!-- Quick view au hover -->
                                                    <div class="quick-view">
                                                        <button class="btn-add">voir</button>
                                                        <div class="rating">
                                                            ★★★★☆
                                                        </div>
                                                    </div>

                                                    <!-- Bouton favoris -->
                                                    <button class="btn-fav">❤</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div id="pagination" class="pagination"></div>

                                </div>

                            </div>
                        </section>
<script>document.querySelectorAll('.view-product').forEach(button => {
    button.addEventListener('click', () => {
        const slug = button.dataset.slug;
        window.location.href = `/produit/${slug}`;
    });
});
</script>

<style>
.products-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
</style>
@endsection
