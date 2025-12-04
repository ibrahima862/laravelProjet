@extends('layouts.app')
@section('css')
    @vite(['resources/css/show.css'])
@endsection
@section('js')
    @vite(['resources/js/show.js'])
@endsection
@section('content')
 <!-- BOUTON MENU -->


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
<div class="product-left">

                <div class="product-gallery">

                    <img id="mainProductImage" class="zoomable"
                        src="{{ asset($produit->img  ?? ($produit->mainImage->filename ?? 'images/default.png')) }}"
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
            @endsection