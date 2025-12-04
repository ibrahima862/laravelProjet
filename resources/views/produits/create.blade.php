@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="container mx-auto px-4 max-w-7xl">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <h1 class="text-4xl font-bold text-gray-800 mb-6">Ajouter un produit</h1>

                <!-- Grid principal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Carte Général -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-box text-indigo-600 text-2xl"></i>
                            <h2 class="text-xl font-semibold text-gray-700">Général</h2>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="categorie_id" class="block text-gray-600 font-medium mb-1">Catégorie</label>
                                <select name="categorie_id" id="categorie_id"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-indigo-200 focus:outline-none">
                                    @foreach ($categories as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @if ($parent->children)
                                            @foreach ($parent->children as $child)
                                                <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                                                @if ($child->children)
                                                    @foreach ($child->children as $subChild)
                                                        <option value="{{ $subChild->id }}">---- {{ $subChild->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="name" class="block text-gray-600 font-medium mb-1">Nom du produit</label>
                                <input type="text" name="name" id="name"
                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"
                                    required>
                            </div>

                            <div>
                                <label for="price" class="block text-gray-600 font-medium mb-1">Prix</label>
                                <input type="number" name="price" min="0" id="price"
                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"
                                    required>
                            </div>

                            <div>
                                <label for="stock" class="block text-gray-600 font-medium mb-1">Stock</label>
                                <input type="number" name="stock" min="0" id="stock"
                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"
                                    required>
                            </div>

                            <div>
                                <label for="badge" class="block text-gray-600 font-medium mb-1">Badge</label>
                                <input type="text" name="badge" id="badge"
                                    class="w-full border border-gray-300 p-2 rounded-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Carte Attributs -->
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 col-span-1 md:col-span-2 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-sliders text-green-600 text-2xl"></i>
                            <h2 class="text-xl font-semibold text-gray-700">Attributs</h2>
                        </div>
                        <div id="attributs-container" class="space-y-4"></div>
                    </div>

                    <!-- Carte Spécifications -->
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 col-span-1 md:col-span-3 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-list text-yellow-600 text-2xl"></i>
                            <h2 class="text-xl font-semibold text-gray-700">Spécifications</h2>
                        </div>
                        <div id="specs-container" class="space-y-2">
                            <div class="spec-item flex gap-2">
                                <input type="text" name="specs[0][key]" placeholder="Caractéristique"
                                    class="flex-1 border border-gray-300 p-2 rounded-lg">
                                <input type="text" name="specs[0][value]" placeholder="Valeur"
                                    class="flex-1 border border-gray-300 p-2 rounded-lg">
                                <button type="button"
                                    class="remove-spec bg-red-500 text-white px-3 rounded hover:bg-red-600 transition">X</button>
                            </div>
                        </div>
                        <button type="button" id="add-spec"
                            class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">➕ Ajouter
                            un détail</button>
                    </div>

                    <!-- Carte Description & Images -->
                    <div
                        class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 col-span-1 md:col-span-3 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-image text-pink-600 text-2xl"></i>
                            <h2 class="text-xl font-semibold text-gray-700">Description & Images</h2>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="description" class="block text-gray-600 font-medium mb-1">Description</label>
                                <textarea name="description" id="description"
                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"></textarea>
                            </div>
                            <div>
                                <label for="img" class="block text-gray-600 font-medium mb-1">Images</label>
                                <input type="file" name="images[]" multiple id="img"
                                    class="w-full border border-gray-300 p-2 rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">Ajouter
                        le produit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Gestion des specs dynamiques
        let specIndex = 1;
        document.getElementById("add-spec").addEventListener("click", () => {
            const container = document.getElementById("specs-container");
            container.insertAdjacentHTML("beforeend", `
            <div class="spec-item flex gap-2">
                <input type="text" name="specs[${specIndex}][key]" placeholder="Caractéristique" class="flex-1 border border-gray-300 p-2 rounded-lg">
                <input type="text" name="specs[${specIndex}][value]" placeholder="Valeur" class="flex-1 border border-gray-300 p-2 rounded-lg">
                <button type="button" class="remove-spec bg-red-500 text-white px-3 rounded hover:bg-red-600 transition">X</button>
            </div>
        `);
            specIndex++;
        });
        document.addEventListener("click", (e) => {
            if (e.target.classList.contains("remove-spec")) e.target.parentElement.remove();
        });

        // Gestion des attributs dynamiques
        document.getElementById('categorie_id').addEventListener('change', function() {
            let categorieId = this.value;

            fetch(`/admin/categorie/${categorieId}/attributs`)
                .then(res => res.json())
                .then(data => {
                    let container = document.getElementById('attributs-container');
                    container.innerHTML = '';

                    let compteur = 0;

                    data.forEach((attribut) => {
                        // Définir la couleur du badge selon le type
                        let badgeColor = 'bg-gray-200 text-gray-800'; // défaut
                        if (attribut.name.toLowerCase().includes('taille')) badgeColor =
                            'bg-blue-100 text-blue-800';
                        else if (attribut.name.toLowerCase().includes('couleur')) badgeColor =
                            'bg-red-100 text-red-800';
                        else if (attribut.name.toLowerCase().includes('matière')) badgeColor =
                            'bg-green-100 text-green-800';
                        else if (attribut.name.toLowerCase().includes('marque')) badgeColor =
                            'bg-yellow-100 text-yellow-800';
                        else if (attribut.name.toLowerCase().includes('stockage') || attribut.name
                            .toLowerCase().includes('ram')) badgeColor =
                        'bg-purple-100 text-purple-800';

                        let html = `<div class="mb-4 p-4 border border-gray-200 rounded shadow-sm bg-gray-50">
                    <label class="block font-medium mb-2">${attribut.name}</label>
                    <div class="flex flex-wrap gap-2">`;

                        attribut.valeurs.forEach(valeur => {
                            html += `<div class="flex items-center gap-2">
                        <input type="checkbox" class="chk-attr" data-index="${compteur}" value="${valeur.id}">
                        <span class="px-2 py-1 rounded-full text-sm font-medium ${badgeColor}">${valeur.value}</span>
                        <input type="hidden" name="attributs[${compteur}][attribut_valeur_id]" class="hidden-attr-id" data-index="${compteur}" value="">
                        <input type="number" name="attributs[${compteur}][stock]" min="0" class="stock-input border p-1 rounded w-20" data-index="${compteur}" value="0" placeholder="Stock" disabled>
                    </div>`;
                            compteur++;
                        });

                        html += `</div></div>`;
                        container.insertAdjacentHTML('beforeend', html);
                    });
                });
        });


        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("chk-attr")) {
                let index = e.target.getAttribute("data-index");
                let stockInput = document.querySelector(`.stock-input[data-index="${index}"]`);
                let hiddenId = document.querySelector(`.hidden-attr-id[data-index="${index}"]`);
                if (e.target.checked) {
                    stockInput.disabled = false;
                    hiddenId.value = e.target.value;
                } else {
                    stockInput.disabled = true;
                    hiddenId.value = "";
                    stockInput.value = 0;
                }
            }
        });
    </script>
@endsection
