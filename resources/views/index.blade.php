@extends('layouts.app')
@section('title', 'Accueil')




@section('css')
    @vite(['resources/css/index.css'])
@endsection

@section('js')
    @vite(['resources/js/index.js'])
@endsection


@section('content')
    <!-- MENU DROPDOWN -->
    <div class="menu-dropdown">
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
                            @foreach ($cat->allProduitsRecursive() as $produit)
                                <div class="product-item">
                                    <div class="product-img">
                                        <img src="{{ asset($produit->img ?? 'images/default.png') }}"
                                            alt="{{ $produit->name }}">
                                        <span class="badge">Promo</span>
                                    </div>

                                    <p class="product-name">{{ $produit->name }}</p>

                                    <div class="product-bottom">
                                        <span class="price">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</span>

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
    </div>
    </div>
    <!-- HERO PRO -->
    <section class="hero" aria-labelledby="heroTitle">
        <div class="hero-overlay"></div>

        <div class="hero-content wrapp">
            <div class="hero-left">
                <h1 id="heroTitle">
                    Achetez malin. Livraison rapide partout au Sénégal.
                </h1>

                <p>
                    Trouvez vos produits au meilleur prix : électronique, mode, beauté,
                    maison, accessoires… Paiement sécurisé & livraison express en 24h.
                </p>

                <div class="hero-buttons">
                    <button class="btn-primary"
                        onclick="document.getElementById('products').scrollIntoView({behavior:'smooth'})">
                        Voir les produits
                    </button>

                    <button class="btn-ghost"
                        onclick="document.getElementById('promos').scrollIntoView({behavior:'smooth'})">
                        Promotions du jour
                    </button>
                </div>

                <div class="hero-badges">
                    <div class="badge"><i class="fas fa-shield-alt"></i> Paiement sécurisé</div>
                    <div class="badge"><i class="fas fa-truck"></i> Livraison 24h</div>
                    <div class="badge"><i class="fas fa-star"></i> +1000 avis 5★</div>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-card">
                    <img src="https://images.pexels.com/photos/8481895/pexels-photo-8481895.jpeg" alt="Produits Sénégal">
                </div>
            </div>
        </div>
    </section>


    <style>
        /* =================== HERO PRO =================== */
        /* HERO PARALLAX PRO */
        .hero {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
        }

        /* Le background bouge à la place */
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('https://images.pexels.com/photos/8481895/pexels-photo-8481895.jpeg') center/cover no-repeat;
            transform: translateY(0);
            transition: transform 0.1s linear;
            will-change: transform;
            z-index: -1;
        }

        /* Overlay */
        .hero-overlay {
            background: rgba(0, 0, 0, 0.45);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            border-radius: 10px;
        }

        .hero::before {
            transform: translateY(calc(var(--parallaxOffset) * -1));
        }

        /* Content */
        .hero-content {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            z-index: 2;
            gap: 40px;

            animation: fadeUp 0.9s ease-out;
        }

        /* LEFT COLUMN */
        .hero-left {
            flex: 1.2;
            animation: slideLeft 0.9s ease-out;
        }

        .hero-left h1 {
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .hero-left p {
            font-size: 1.rem;
            color: #e0e0e0;
            max-width: 520px;
            margin-bottom: 25px;
        }

        /* CTA Buttons */
        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #2563eb, #4f46e5);
            padding: 6px 12px;
            border: none;
            color: white;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: .3s;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-3px);
        }

        .btn-ghost {
            padding: 6px 12px;
            border-radius: 10px;
            border: 2px solid #f2f2f2;
            background: rgb(255, 255, 255);
            color: #002eb9;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .btn-ghost:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-3px);
        }

        /* BADGES */
        .hero-badges {
            display: flex;
            gap: 15px;

        }

        .hero-badges .badge {
            background: rgba(255, 15, 15, 0.572);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(4px);

        }

        /* RIGHT IMAGE */
        .hero-right {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .hero-card {
            width: 380px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);

            animation: slideRight 0.9s ease-out;
        }

        .hero-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ANIMATIONS */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .hero-content {
                flex-direction: column-reverse;
                text-align: center;
            }

            .hero-left h1 {
                font-size: 2rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-badges {
                justify-content: center;
            }
        }
    </style>


    <main class="wrap">
        <div class="main-all-content">
            <!-- ORDER / COMMANDE (version locale innovante) -->
          <aside class="order-box modern-order">
    <div class="order-header">Options d’achat</div>

   <div class="product-preview-box">
    <div class="preview-header">Vos avantages en un coup d’œil</div>

    <div class="preview-grid">
        <div class="tier">
            <i class="far fa-bolt"></i>
            <div>
                <strong>Livraison express</strong>
                <span>24h partout au Sénégal</span>
            </div>
        </div>

        <div class="tier">
            <i class="far fa-fire"></i>
            <div>
                <strong>Produits tendances</strong>
                <span>Top 20 du moment</span>
            </div>
        </div>

        <div class="tier">
            <i class="far fa-gem"></i>
            <div>
                <strong>Exclusivités</strong>
                <span>Séries limitées</span>
            </div>
        </div>

        <div class="tier">
            <i class="far fa-gift"></i>
            <div>
                <strong>Offres personnalisées</strong>
                <span>Pour membres</span>
            </div>
        </div>

        <div class="tier">
            <i class="far fa-star"></i>
            <div>
                <strong>Top avis</strong>
                <span>+1000 avis 4★</span>
            </div>
        </div>

        <div class="tier">
            <i class="far fa-comment"></i>
            <div>
                <strong>Support 24/7</strong>
                <span>Nous répondons vite</span>
            </div>
        </div>
    </div>

    <div class="product-preview-actions">
        <button class="btn btn-primary" onclick="scrollToSection('newProducts')">Voir nouveautés</button>
        <button class="btn btn-success" onclick="scrollToSection('products')">Tous les produits</button>
    </div>
</div>


    <!-- Infos -->
    <div class="order-info">
        <div class="info-item"><i class="fas fa-truck"></i> Livraison rapide</div>
        <div class="info-item"><i class="fas fa-tags"></i> Promotions régulières</div>
        <div class="info-item"><i class="fas fa-users"></i> +1 000 clients satisfaits</div>
        <div class="info-item"><i class="fas fa-lock"></i> Paiement sécurisé</div>
        <div class="info-item"><i class="fas fa-headset"></i> Support réactif</div>
    </div>

    <!-- Filtres -->
    <div class="supplier-filters">
        <div class="filter-group">
            <label>Catégorie</label>
            <select>
                <option>Électronique</option>
                <option>Mode</option>
                <option>Maison</option>
                <option>Beauté</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Prix (FCFA)</label>
            <div class="price-range">
                <input type="number" placeholder="Min">
                <span>-</span>
                <input type="number" placeholder="Max">
                <button class="btn btn-success">OK</button>
            </div>
        </div>

        <div class="filter-group">
            <label>Promotions</label>
            <div class="check-list">
                <label><input type="checkbox"> Flash 24h</label>
                <label><input type="checkbox"> Offres de la semaine</label>
            </div>
        </div>

        <div class="filter-group">
            <label>État du produit</label>
            <div class="check-list">
                <label><input type="radio" name="cond"> Neuf</label>
                <label><input type="radio" name="cond"> Reconditionné</label>
            </div>
        </div>
    </div>
</aside>


            <div class="main-product-container">
                <div class="promo-strip">
                    <div class="pill">Livraison offerte dès 30 000 FCFA</div>
                    <div style="color:var(--muted); font-weight:700">Retour gratuit sous 14 jours</div>
                </div>

                <!-- CATEGORIES -->
                <section id="categories">
                    <h2 style="text-align:center; margin-bottom:20px">Catégories populaires</h2>

                    <div class="categories-carousel">
                        <button class="carousel-btn prev">&lt;</button>

                        <div class="carousel-track">
                            @foreach ($categories as $cat)
                                <div class="cat-card" tabindex="0">
                                    <div class="cat-media">
                                        <img data-src="{{ asset('categories/' . $cat->image) }}" alt="{{ $cat->name }}"
                                            class="lazy">
                                        <span class="badge">Top</span>
                                        <div class="overlay">
                                            <span>Voir les produits</span>
                                        </div>
                                    </div>
                                    <div class="cat-info">
                                        <strong>{{ $cat->name }}</strong>
                                        <p class="muted">{{ $cat->slug }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-btn next">&gt;</button>
                    </div>
                </section>



                <div class="products-container">
                    <div class="under-products-container">
                        <!-- NOUVEAUX PRODUITS -->
                        <section id="newProducts" class="products" aria-labelledby="newProductsTitle">
                            <div class="section-head">
                                <h2 id="produits-title">Découvrez notre sélection <br> de produits incontournables</h2>
                                <div class="annonce-container">

                                    <div class="annonce-content">
                                        <span class="message active">🔥 -50% sur la collection Automne 🍂</span>
                                        <span class="message">🚚 Livraison gratuite dès 25 000 FCFA</span>
                                        <span class="message">🆕 Découvrez nos nouveautés exclusives</span>
                                        <span class="message">💬 Support client 24/7 à votre écoute</span>
                                    </div>
                                </div>
                            </div>

                            <div class="products-section">
                                <div id="grid" class="product-grid" aria-live="polite">
                                    @foreach ($newProducts as $produit)
                                        <div class="product-card dynamic-card view-product"
                                            data-slug="{{ $produit->slug }}" data-images='@json($produit->images->pluck('filename'))'>

                                            <!-- Carrousel d’images -->
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


                                            <!-- Infos produit -->
                                            <div class="product-info">
                                                <h3>{{ $produit->name }}</h3>
                                                <p class="short-desc">
                                                    {{ $produit->short_description ?? 'Description rapide du produit...' }}
                                                </p>

                                                @php
                                                    $reduction = 0;
                                                    if (preg_match('/-([0-9]+)%/', $produit->badge ?? '', $matches)) {
                                                        $reduction = (int) $matches[1];
                                                    }
                                                    $prixReduit =
                                                        $reduction > 0
                                                            ? $produit->price - ($produit->price * $reduction) / 100
                                                            : null;
                                                @endphp

                                                <p class="price">
                                                    @if ($prixReduit)
                                                        <span
                                                            class="old">{{ number_format($produit->price, 0, ',', ' ') }}
                                                            FCFA</span>
                                                        <span class="new">{{ number_format($prixReduit, 0, ',', ' ') }}
                                                            FCFA</span>
                                                    @else
                                                        {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                                                    @endif
                                                </p>

                                                <!-- Quick view au hover -->
                                                <div class="quick-view">
                                                    <button class="btn-add">Voir</button>
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
                                <div class="button-more">
                                    <button id="loadMoreNewProducts" class="btn-load">
                                        <span>Voir plus</span>
                                    </button>
                                </div>
                            </div>

                        </section>

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
                    </div>

                </div>

                <!-- Overlay semi-transparent -->
                <div id="sidebarOverlay" class="sidebar-overlay"></div>

                <!-- FEATURES -->
                <section class="features" aria-labelledby="featuresTitle">
                    <h2 id="featuresTitle" class="features-title">Pourquoi acheter chez nous ?</h2>
                    <div class="features-grid">
                        <div class="feature" data-animate>
                            <div class="feature-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/679/679922.png" alt="Livraison rapide">
                                <span class="check-badge">✔</span>
                            </div>
                            <h3>Livraison rapide</h3>
                            <p>Recevez vos commandes en 24h à Dakar et sous 72h partout au Sénégal.</p>
                        </div>
                        <div class="feature" data-animate>
                            <div class="feature-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" alt="Paiement sécurisé">
                                <span class="check-badge">✔</span>
                            </div>
                            <h3>Paiement sécurisé</h3>
                            <p>Carte bancaire, Mobile Money ou paiement à la livraison en toute confiance.</p>
                        </div>
                        <div class="feature" data-animate>
                            <div class="feature-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Retours faciles">
                                <span class="check-badge">✔</span>
                            </div>
                            <h3>Retours faciles</h3>
                            <p>Retournez vos articles sous 14 jours si vous changez d’avis.</p>
                        </div>
                    </div>
                    <!-- Background décoratif -->
                    <div class="features-bg"></div>
                </section>




                <!-- Produits récemment consultés -->

                <section id="recentlyViewedSection">
                    <div class="section-head">
                        <h2 id="produits-title">vue recemment</h2>
                    </div>
                    <div id="grid" class="product-grid" aria-live="polite">
                        @foreach ($recentlyViewed as $produit)
                            <div class="product-card dynamic-card view-product"data-slug="{{ $produit->slug }}">
                                <div class="product-image">
                                    <img src="{{ asset($produit->img ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
                                        alt="{{ $produit->name }}">
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
                                            <span class="old">{{ number_format($produit->price, 0, ',', ' ') }}
                                                FCFA</span>
                                            <span class="new">{{ number_format($prixReduit, 0, ',', ' ') }}
                                                FCFA</span>
                                        </p>
                                    @else
                                        <p class="price">
                                            {{ number_format($produit->price, 0, ',', ' ') }} FCFA</p>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- NEWSLETTER -->
                <section style="margin-top:26px">
                    <div class="newsletter">
                        <div class="n-left">
                            <h3>Restez informé</h3>
                            <p class="muted">Recevez nos offres et nouveautés directement dans votre boîte mail.</p>
                        </div>
                        <form id="newsForm" onsubmit="subscribe(event)">
                            <input id="newsEmail" type="email" placeholder="Votre email" required aria-label="Email">
                            <button class="btn btn--primary" type="submit">S'abonner</button>
                            <span class="ok" id="okTick">✓</span>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <section class="about-full">
        <div class="container">
            <h2>Senshop Le site de vente en ligne Numéro 1 au Sénégal crée par de jeunes sénégalais</h2>
            <h2>Qui sommes-nous ?</h2>
            <p class="intro">
                <strong>SenShop</strong>, la plateforme e-commerce de référence au Sénégal,
                créée par de jeunes entrepreneurs sénégalais passionnés par l’innovation et
                le commerce digital.
                Nous mettons à votre disposition une large gamme de produits de qualité
                aux meilleurs prix, livrés rapidement partout dans le pays.
            </p>

            <h3>Notre mission</h3>
            <p>
                Chez <strong>SenShop</strong>, notre mission est de rendre vos achats
                plus simples, plus rapides et plus sûrs. De l’électronique dernier cri
                aux articles de mode, en passant par l’électroménager, la beauté,
                le mobilier et même l’artisanat local, nous vous offrons tout ce dont
                vous avez besoin au quotidien — en quelques clics seulement.
            </p>

            <h3>Pourquoi choisir SenShop ?</h3>
            <ul class="reasons">
                <li><i class="fas fa-tags"></i> Produits 100% authentiques et certifiés</li>
                <li><i class="fas fa-bolt"></i> Livraison express en 24h partout au Sénégal</li>
                <li><i class="fas fa-gift"></i> Promotions exclusives et offres spéciales</li>
                <li><i class="fas fa-lock"></i> Paiements sécurisés par Mobile Money et carte bancaire</li>
                <li><i class="fas fa-star"></i> Plus de 5 000 clients satisfaits</li>
                <li><i class="fas fa-headset"></i> Support client disponible 24/7</li>
            </ul>

            <h3>Nos engagements</h3>
            <p>
                Nous travaillons en partenariat avec les plus grandes marques telles que
                <em>Samsung, Tecno, Infinix, HP, Roch, Sharp</em> et bien d’autres, afin de vous
                garantir des produits de qualité irréprochable. Grâce à notre réseau logistique,
                vous bénéficiez d’une livraison rapide, fiable et parfois gratuite selon les produits.
            </p>

            <h3>Des offres toute l’année</h3>
            <p>
                Profitez de nos <strong>promotions quotidiennes</strong>, de la
                <strong>promo de la semaine</strong> et de notre
                <strong>offre spéciale bazar</strong>, qui vous permettent de faire
                des économies tout en accédant aux meilleures nouveautés du marché.
            </p>

            <div class="cta">
                <a href="#products" class="btn-primary">Découvrir nos produits</a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ==========================
            // 🔹 FILTER GRID
            // ==========================
            window.filterGrid = function() {
                const q = document.getElementById("searchInput").value.toLowerCase();
                const cards = document.querySelectorAll("#grid .product-card");

                cards.forEach(card => {
                    const name = card.dataset.name.toLowerCase();
                    const category = card.dataset.category.toLowerCase();
                    card.style.display = (name.includes(q) || category.includes(q)) ? "block" : "none";
                });
            };

            // ==========================
            // 🔹 HERO CAROUSEL
            // ==========================
            const slides = document.querySelectorAll('#heroCarousel img');
            const dots = document.querySelectorAll('.carousel-controls .dot');
            const carouselText = document.querySelector('.carousel-text');

            if (slides.length && dots.length) {
                let carouselIndex = 0;

                const showSlide = (index) => {
                    slides.forEach(slide => slide.classList.remove('active'));
                    dots.forEach(dot => dot.classList.remove('active'));
                    if (slides[index]) slides[index].classList.add('active');
                    if (dots[index]) dots[index].classList.add('active');
                    if (slides[index] && carouselText) carouselText.textContent = slides[index].dataset.text ||
                        '';
                };

                const nextSlide = () => {
                    carouselIndex = (carouselIndex + 1) % slides.length;
                    showSlide(carouselIndex);
                };

                dots.forEach((dot, i) => dot.addEventListener('click', () => {
                    carouselIndex = i;
                    showSlide(carouselIndex);
                }));

                setInterval(nextSlide, 5000);
                showSlide(carouselIndex);
            }

            // ==========================
            // 🔹 FEATURES ANIMATION
            // ==========================
            const observedFeatures = document.querySelectorAll('.feature[data-animate]');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('show');
                });
            }, {
                threshold: 0.3
            });
            observedFeatures.forEach(feature => observer.observe(feature));

            // ==========================
            // 🔹 IMAGE SLIDERS IN PRODUCTS
            // ==========================
            document.querySelectorAll('.image-slider').forEach(slider => {
                const images = JSON.parse(slider.dataset.images || "[]");
                const firstImg = slider.querySelector("img");
                const dotsContainer = slider.querySelector('.dots-container');
                const allImgs = [firstImg];

                images.forEach(src => {
                    const img = document.createElement("img");
                    img.src = "/" + src;
                    slider.appendChild(img);
                    allImgs.push(img);
                });

                allImgs.forEach((img, i) => img.classList.toggle("active", i === 0));

                const allDots = [];
                allImgs.forEach((_, i) => {
                    const dot = document.createElement("span");
                    dot.classList.add("dot");
                    if (i === 0) dot.classList.add("active");
                    dot.addEventListener("click", () => showImage(i));
                    dotsContainer.appendChild(dot);
                    allDots.push(dot);
                });

                let current = 0;
                const showImage = (i) => {
                    allImgs.forEach((img, idx) => img.classList.toggle("active", idx === i));
                    allDots.forEach((dot, idx) => dot.classList.toggle("active", idx === i));
                    current = i;
                };

                slider.querySelector(".right-btn")?.addEventListener("click", e => {
                    e.stopPropagation();
                    showImage((current + 1) % allImgs.length);
                });

                slider.querySelector(".left-btn")?.addEventListener("click", e => {
                    e.stopPropagation();
                    showImage((current - 1 + allImgs.length) % allImgs.length);
                });
            });

            // ==========================
            // 🔹 PARALLAX HERO
            // ==========================
            const hero = document.querySelector(".hero");
            if (hero) {
                document.addEventListener("scroll", () => {
                    const rect = hero.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        hero.style.setProperty("--offset", rect.top * -0.25);
                    }
                });
            }

            // ==========================
            // 🔹 CAROUSEL SCROLL
            // ==========================
            const track = document.querySelector('.carousel-track');
            const nextBtn = document.querySelector('.carousel-btn.next');
            const prevBtn = document.querySelector('.carousel-btn.prev');
            const scrollAmount = 250;

            nextBtn?.addEventListener('click', () => track.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            }));
            prevBtn?.addEventListener('click', () => track.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            }));

            // ==========================
            // 🔹 LAZY LOADING
            // ==========================
            const lazyImages = document.querySelectorAll('.lazy');
            const imgObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: "100px 0px"
            });

            lazyImages.forEach(img => imgObserver.observe(img));

        });
    </script>
@endsection