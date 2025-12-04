<header class="topbar">
    <div class="container">

        <!-- Logo -->
        <div class="brand">
            <div class="logo-box">ME</div>
            <div class="brand-text">Mini <span class="primary">E-commerce</span></div>
        </div>

        <!-- Search -->
        <form action="{{ route('Allproduits.index') }}" method="GET" class="search" role="search">
            <div class="search-wrapper">
                <input name="q" id="searchInput" placeholder="Rechercher (ex: chaussures, montre)..."
                    autocomplete="off">
                <button class="icon-btn" type="submit">🔍</button>
                <div id="suggestionsBox" class="suggestions-box"></div>
            </div>
        </form>

        <!-- Navigation -->
        <nav class="main-nav">
            <a href="">Accueil</a>
            <a href="{{ route('Allproduits.index') }}">Produits</a>

            <a href="#blog">Blog</a>
        </nav>

        <!-- User + Cart -->
        <div class="user-cart">
            @if (Auth::check())
                <a href="" class="btn-login"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>

                <a href="{{ route('notifications.index') }}" class="btn-login notifications-icon">
                    <i class="fa fa-bell"></i>
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <span class="badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-login">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-login">S'inscrire</a>
            @endif

            <a href="{{ route('panier.index') }}" class="cart-btn">
                <i class="fa fa-shopping-cart"></i>
                Panier
                <span class="cart-count" id="cartCount">{{ $totalProducts ?? 0 }}</span>
            </a>
        </div>

        <!-- Hamburger -->
        <button id="hamburgerOpen" class="hamburger"><i class="fa fa-bars"></i></button>

    </div>
</header>
