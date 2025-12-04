@extends('layouts.app')
@section('title', $produit->name)
@section('css')
    @vite(['resources/css/show.css'])
@endsection

@section('js')
    @vite(['resources/js/show.js'])
@endsection

@section('content')

    <!-- BOUTON MENU -->


    <!-- MENU DROPDOWN -->
    <div class="menu-dropdown no-product-scan">
        <div class="menu-item-container">

            <!-- MENU LEFT (Catégories) -->
            <div class="menu-left">
                @foreach ($categories as $parent)
                    <div class="menu-item" data-cat-id="{{ $parent->id }}">
                        <div class="menu-title">
                            <i class="{{ $parent->icon }}"></i>
                            <span>{{ $parent->name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- MENU RIGHT (Titre + Produits) -->


            <div class="menu-right">
                <h3 class="category-title">Sélectionnez une catégorie</h3>

                @foreach ($categories as $cat)
                    <div class="products-sections" data-cat-id="{{ $cat->id }}">
                        @foreach ($cat->allProduitsRecursive() as $catproduit)
                            <div class="product-item">
                                <div class="product-img">
                                    <img src="{{ asset($catproduit->img ?? 'images/default.png') }}"
                                        alt="{{ $catproduit->name }}">
                                    <span class="badge">Promo</span>
                                </div>

                                <p class="product-name">{{$catproduit->name }}</p>

                                <div class="product-bottom">
                                    <span class="price">{{ number_format($catproduit->price, 0, ',', ' ') }} FCFA</span>

                                    <button class="view-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>



        </div>
    </div>


    <!--ici qu'est ce que tu me suggere pour enrichir la page comme vrai site ecommerce -->
    <div class="product-page-main">
        <div class="product-breadcrumb-box">
            <div class="category-path">
                Commercial Equipment & Machinery › Digital Signage › LCD Display
            </div>
            <h1 class="product-title">
                {{ $produit->name }}
            </h1>

            <p class="reviews-info">No reviews yet</p>
        </div>
        <div class="product-page">
            <!-- Sidebar à droite -->
            <div class="product-sidebar-left">

                <!-- READY TO SHIP -->
                <div class="sidebar-box-left ready-ship">
                    <div class="icon-text">
                        <img src="/images/icons/rocket.svg" alt="Ready to ship">
                        <div>
                            <p class="ready">Ready to ship</p>
                            <p class="expedition">Expédition en 5 jours</p>
                        </div>
                    </div>
                </div>

                <!-- PRICE TIERS -->
                <div class="sidebar-box-left price-tier">
                    <p class="section-title">Prix selon quantité</p>
                    <div class="tier">
                        <span>2 - 49 pièces</span>
                        <strong>8 874 FCFA</strong>
                    </div>
                    <div class="tier">
                        <span>50 - 999 pièces</span>
                        <strong>7 099 FCFA</strong>
                    </div>
                    <div class="tier">
                        <span>>= 1000 pièces</span>
                        <strong>5 621 FCFA</strong>
                    </div>
                </div>

                <!-- SAMPLE PRICE -->
                <div class="sidebar-box-left sample-price-box">
                    <p><strong>Prix de l’échantillon :</strong> 29 580 FCFA</p>
                    <button class="btn-primary">Obtenir</button>
                </div>

                <!-- OPTIONS -->
                <div class="sidebar-box-left options-box">
                    <p class="section-title">Options</p>

                    @php
                        $couleurs = $produit->attributvaleurs->filter(fn($v) => $v->attribut->name === 'Couleur');
                        $tailles = $produit->attributvaleurs->filter(fn($v) => $v->attribut->name === 'Taille');
                    @endphp

                    <label>Couleur :</label>
                    <select name="color">
                        @foreach ($couleurs as $couleur)
                            <option value="{{ $couleur->id }}">{{ $couleur->value }}</option>
                        @endforeach
                    </select>

                    <label>Taille :</label>
                    <select name="taille">
                        @foreach ($tailles as $taille)
                            <option value="{{ $taille->id }}">
                                {{ $taille->value }} (Stock : {{ $taille->pivot->stock }})
                            </option>
                        @endforeach
                    </select>

                    <div class="option-actions">
                        <button class="btn-qty minus">-</button>
                        <input type="number" class="qty" value="1" min="1">
                        <button class="btn-qty plus">+</button>
                    </div>
                </div>

                <!-- SHIPPING -->
                <div class="sidebar-box-left shipping-box">
                    <p class="section-title">Expédition</p>
                    <div class="shipping-method">
                        <strong>Économique</strong>
                        <a href="#" class="change-btn">Changer</a>
                    </div>
                    <p>Frais de port: <strong>31 869 FCFA</strong> pour 2 pièces</p>
                    <p class="delivery-guarantee">
                        Livraison garantie d'ici le <strong>28 janv.</strong>
                    </p>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="sidebar-box-left actions">
                    <button class="btn-primary btn-add-cart">Ajouter au panier</button>
                    <button class="btn-chat">Chat avec le vendeur</button>
                </div>

            </div>


            <!-- Colonne gauche : image + description -->
            <div class="product-left">

                <div class="product-gallery">

                    <img id="mainProductImage"
                        src="{{ asset($produit->img ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
                        alt="{{ $produit->name }}">

                    <div class="infos-product">
                        <span class="badge">{{ $produit->badge }}</span>
                    </div>
                </div>
                <div class="image-gallery-wrapper">
                    <button class="scroll-btn left">&lt;</button>

                    <div class="product-all-images" id="imageSlider">
                        @foreach ($produit_gallery as $image)
                            <img class="thumbnail" src="{{ asset($image->filename ?? 'images/default.png') }}"
                                alt="{{ $image->name }}">
                        @endforeach
                    </div>

                    <button class="scroll-btn right">&gt;</button>
                </div>

                @php
                    // Regrouper les attributs par type (attribut)
                    $attributsParType = $produit->attributvaleurs->groupBy(fn($val) => $val->attribut->name);
                @endphp

                @if ($produit->attributvaleurs->count() > 0)
                    <div class="produit-variant">
                        <h4>Options disponibles</h4>
                        <div class="variant-options">
                            @foreach ($attributsParType as $type => $valeurs)
                                <label>{{ $type }} :</label>

                                @foreach ($valeurs as $valeur)
                                    <button class="taille-btn {{ $valeur->pivot->stock <= 0 ? 'out-of-stock' : '' }}"
                                        value="{{ $valeur->id }}" {{ $valeur->pivot->stock <= 0 ? 'disabled' : '' }}>
                                        {{ $valeur->value }}
                                    </button>
                                @endforeach
                            @endforeach

                        </div>
                    </div>
                @endif
                <div class="description-box">
                    <h2>Description</h2>
                    <p>{{ $produit->description }}</p>
                    <span id="toggle-desc" class="toggle-desc">▼ plus</span>
                </div>
                <div class="product-specs">
                    <h3>Détails techniques</h3>
                    <table class="specs-table">
                        <tbody>
                            <tr>
                                <td>Matériau de la tige</td>
                                <td>{{ $produit->material ?? 'Cuir / Textile' }}</td>
                            </tr>
                            <tr>
                                <td>Doublure</td>
                                <td>{{ $produit->lining ?? 'Textile doux ou cuir' }}</td>
                            </tr>
                            <tr>
                                <td>Semelle intérieure</td>
                                <td>{{ $produit->insole ?? 'Amortissante et ergonomique' }}</td>
                            </tr>
                            <tr>
                                <td>Semelle extérieure</td>
                                <td>{{ $produit->outsole ?? 'Caoutchouc antidérapant' }}</td>
                            </tr>
                            <tr>
                                <td>Poids</td>
                                <td>{{ $produit->weight ?? '450 g' }}</td>
                            </tr>
                            <tr>
                                <td>Guide des tailles</td>
                                <td>{{ $produit->size_guide ?? 'Voir le guide' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="panelOverlay"></div>
            <div id="taillePanel" class="panel hidden">
                <div class="panel-header">
                    <h3>Veuillez sélectionner une option</h3>
                    <button class="close-btn">✕</button>
                </div>

                <div class="panel-content">
                    @php
                        $attributsParType = $produit->attributvaleurs->groupBy(fn($val) => $val->attribut->name);
                    @endphp

                    @foreach ($attributsParType as $type => $valeurs)
                        @foreach ($valeurs as $val)
                            <div class="option-card {{ $val->pivot->stock <= 0 ? 'disabled' : '' }}">
                                <div class="option-info">
                                    <span class="option-name">{{ $val->value }}</span>
                                    <span class="option-prix">{{ number_format($val->pivot->prix_achat, 0, ',', ' ') }}
                                        FCFA</span>
                                    <span
                                        class="option-prix-vente">{{ number_format($val->pivot->prix_vente, 0, ',', ' ') }}
                                        FCFA</span>
                                    <span class="option-stock">{{ $val->pivot->stock }} articles seulement</span>
                                </div>

                                @if ($val->pivot->stock > 0)
                                    <div class="option-actions">
                                        <button class="minus">-</button>
                                        <input type="number" class="qty" value="0" min="0"
                                            max="{{ $val->pivot->stock }}">
                                        <input type="hidden" class="pivot-id" value="{{ $val->pivot->id }}">
                                        <button type="button" class="plus">+</button> <!-- Ajout du bouton + -->
                                    </div>
                                @else
                                    <span class="indispo">epuisé</span>
                                @endif
                            </div>
                        @endforeach
                    @endforeach

                    @php
                        $indisponibles = $produit->attributvaleurs
                            ->filter(fn($val) => $val->pivot->stock <= 0)
                            ->pluck('value')
                            ->toArray();
                    @endphp
                    @if (count($indisponibles))
                        <div class="indispo-global">
                            Actuellement indisponible: {{ implode(', ', $indisponibles) }}
                        </div>
                    @endif
                </div>

                <div class="panel-footer">
                    <button id="add-all-to-cart" class="btn-panier" data-id="{{ $produit->id }}">Ajouter toutes les
                        tailles au panier</button>
                </div>
            </div>


            <!-- Sidebar à droite -->
            <div class="product-sidebar">

                <!-- PRICE BOX -->
                <div class="sidebar-box price-section">
                    <div class="price-now">Now
                        <span>{{ number_format($produit->prixReduit() ?? $produit->price, 0, ',', ' ') }} FCFA</span>
                    </div>

                    @if ($produit->prixReduit())
                        <div class="price-old">Was {{ number_format($produit->price, 0, ',', ' ') }} FCFA</div>
                        <div class="price-save">
                            You save
                            <span>
                                {{ number_format($produit->price - $produit->prixReduit(), 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    @endif

                    <div class="online-price">Price when purchased online</div>
                </div>

                <!-- RETURNS -->
                <div class="sidebar-box">
                    <p class="returns"><strong>Free 90-day returns</strong></p>
                </div>

                <!-- ADD TO CART -->
                <div class="sidebar-box">
                    <button class="add-to-cart-sidebar">Ajouter au panier</button>
                </div>

                <!-- DELIVERY OPTIONS -->
                <div class="sidebar-box delivery-section">
                    <p class="section-title">How you'll get this item:</p>

                    <div class="delivery-option">
                        <div class="icon">🚚</div>
                        <div>
                            <strong>Shipping</strong>
                            <p>Arrives tomorrow</p>
                            <small>Order within 6h 35 min</small>
                        </div>
                    </div>

                    <div class="delivery-option disabled">
                        <div class="icon">📦</div>
                        <div>
                            @foreach ($livraisons as $livraison)
                                <strong>{{ $livraison->type }}</strong>
                                <p>{{ $livraison->price }}</p>
                            @endforeach
                        </div>
                    </div>



                    <div class="address-row">
                        <span>Sacramento, 95829</span>
                        <a href="#" class="change-btn">Change</a>
                    </div>

                    <p class="arrival-info">Arrives by Tomorrow.</p>
                </div>
                <!-- SELLER INFO -->
                <div class="sidebar-box seller-section">
                    <p>
                        Sold by <strong>{{ $produit->seller ?? 'Cate & Chloe' }}</strong> |
                        <span class="badge-pro">Pro Seller</span>
                    </p>

                    <p>Fulfilled by <strong>Walmart</strong></p>

                    <div class="seller-rating">
                        ⭐ 4.6 (22155 reviews)
                    </div>

                    <a href="#" class="report-issue">Report an issue with this seller</a>
                </div>
            </div>





        </div>

    </div>


    <div class="related-products">
        <h3>Produits similaires</h3>
        <div class="related-list">
            @foreach ($relatedProducts as $related)
                <div class="related-item">

                    <!-- IMAGE + BADGE -->
                    <div class="related-image">
                        <img src="{{ asset($related->img ?? 'images/default.png') }}" alt="{{ $related->name }}">
                        @if ($related->badge)
                            <span class="badge">{{ $related->badge }}</span>
                        @endif
                    </div>

                    <!-- NOM DU PRODUIT -->
                    <div class="related-info">
                        <p class="product-name">{{ $related->name }}</p>
                    </div>

                    <!-- PRIX -->
                    @php
                        $reduction = 0;
                        if (preg_match('/-([0-9]+)%/', $related->badge, $matches)) {
                            $reduction = (int) $matches[1];
                        }
                        $prixReduit = $reduction > 0 ? $related->price - ($related->price * $reduction) / 100 : null;
                    @endphp
                    <div class="related-price">
                        @if ($prixReduit)
                            <span class="old-price">{{ number_format($related->price, 0, ',', ' ') }} FCFA</span>
                            <span class="new-price">{{ number_format($prixReduit, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="price">{{ number_format($related->price, 0, ',', ' ') }} FCFA</span>
                        @endif
                    </div>

                    <!-- ACTIONS -->
                    <div class="related-actions">
                        <button class="btn btn-view view-product" data-slug="{{ $related->slug }}">Voir</button>
                        <button class="add-to-cart-related" data-id="{{ $related->id }}">🛒 Ajouter</button>
                    </div>

                </div>
            @endforeach
        </div>

    </div>

    </div>
    <script>
        const slider = document.getElementById('imageSlider');
        const btnLeft = document.querySelector('.scroll-btn.left');
        const btnRight = document.querySelector('.scroll-btn.right');

        btnRight.addEventListener('click', () => {
            slider.scrollBy({
                left: 150,
                behavior: 'smooth'
            });
        });

        btnLeft.addEventListener('click', () => {
            slider.scrollBy({
                left: -150,
                behavior: 'smooth'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('#heroCarousel img');
            const dots = document.querySelectorAll('.carousel-controls .dot');
            const carouselText = document.querySelector('.carousel-text');

            if (!slides.length || !dots.length) {
                console.warn('Carousel or dots not found!');
                return;
            }

            let carouselIndex = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // sécurité : vérifier que l'index existe
                if (slides[index]) slides[index].classList.add('active');
                if (dots[index]) dots[index].classList.add('active');

                if (slides[index] && carouselText) carouselText.textContent = slides[index].dataset.text;
            }

            function nextSlide() {
                carouselIndex = (carouselIndex + 1) % slides.length;
                showSlide(carouselIndex);
            }

            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    carouselIndex = i;
                    showSlide(carouselIndex);
                });
            });

            setInterval(nextSlide, 5000);
            showSlide(carouselIndex);
        });
    </script>
@endsection
