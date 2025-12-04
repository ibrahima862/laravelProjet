const searchInput = document.getElementById('searchInput');
const suggestionsBox = document.getElementById('suggestionsBox');

searchInput.addEventListener('input', async () => {
    const query = searchInput.value.trim();

    if (query.length < 2) {
        suggestionsBox.style.display = 'none';
        return;
    }

    // Remplacer l'URL par votre route AJAX qui renvoie les résultats JSON
    const response = await fetch(`/search-suggestions?q=${encodeURIComponent(query)}`);
    const results = await response.json();

    suggestionsBox.innerHTML = '';

    if (results.length === 0) {
        suggestionsBox.style.display = 'none';
        return;
    }

    results.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('suggestion-item');

        div.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
    <div class="info">
        <span class="name">${item.name}</span>
        <span class="price">${item.price} CFA</span>
    </div>
        `;

        div.addEventListener('click', () => {
            searchInput.value = item.name;
            suggestionsBox.style.display = 'none';
            // Optionnel : soumettre le formulaire directement
            // searchInput.closest('form').submit();
        });

        suggestionsBox.appendChild(div);
    });

    suggestionsBox.style.display = 'block';
});

// Fermer les suggestions si on clique en dehors
document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.style.display = 'none';
    }
});

        function filterGrid() {
            let q = document.getElementById("searchInput").value.toLowerCase();
            let cards = document.querySelectorAll("#grid .product-card");

            cards.forEach(card => {
                let name = card.dataset.name.toLowerCase();
                let category = card.dataset.category.toLowerCase();

                if (name.includes(q) || category.includes(q)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }
   
      