window.addEventListener('load', () => {
    const mainImage = document.getElementById('mainProductImage');

    document.querySelectorAll('.product-all-images .thumbnail').forEach(img => {
        img.addEventListener('click', () => {
            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.src = img.src;
                mainImage.alt = img.alt;
                mainImage.style.opacity = 1;
            }, 200);
        });
    });

    mainImage.addEventListener('click', function () {
        const lightbox = document.createElement('div');
        lightbox.classList.add('lightbox');
        lightbox.innerHTML = `<img src="${this.src}" alt="${this.alt}">`;
        document.body.appendChild(lightbox);
        lightbox.addEventListener('click', () => document.body.removeChild(lightbox));
    });

    const descBox = document.querySelector('.description-box');
    const toggleBtn = document.getElementById('toggle-desc');
    toggleBtn.addEventListener('click', () => {
        descBox.classList.toggle('expanded');
        toggleBtn.textContent = descBox.classList.contains('expanded') ? '▲ Voir moins' : '▼ Lire plus';
    });
});


document.addEventListener("DOMContentLoaded", () => {

    const hamburger = document.querySelector('.hamburger');
    const dropdown = document.querySelector('.menu-dropdown');

    const menuContainer = document.querySelector('.menu-item-container');
    const menuLeftItems = document.querySelectorAll('.menu-item');
    const productSections = document.querySelectorAll('.products-sections');
    const menuRight = document.querySelector('.menu-right');

    const categoryTitle = document.querySelector('.category-title');

    /* --- OUVERTURE / FERMETURE MENU --- */
    function openMenu() {
        dropdown.classList.add('active');
    }
    function closeMenu() {
        dropdown.classList.remove('active');
    }

    hamburger.addEventListener('mouseenter', openMenu);
    dropdown.addEventListener('mouseenter', openMenu);

    hamburger.addEventListener('mouseleave', () => {
        setTimeout(() => {
            if (!dropdown.matches(':hover')) closeMenu();
        }, 200);
    });

    dropdown.addEventListener('mouseleave', closeMenu);

    /* --- UPDATE PRODUITS + TITRE --- */
    function updateCategory(catId, catName) {

        // Animation du titre
        categoryTitle.classList.remove("show");

        setTimeout(() => {
            categoryTitle.textContent = catName;
            categoryTitle.classList.add("show");
        }, 140);

        // Afficher uniquement la bonne section
        productSections.forEach(section => {
            section.classList.toggle("active", section.dataset.catId === catId);
        });

        // Afficher menu-right
        menuRight.style.display = "flex";

        // Highlight
        menuLeftItems.forEach(i => i.classList.remove('active'));
        document.querySelector(`.menu-item[data-cat-id="${catId}"]`)?.classList.add('active');
    }

    /* SURVOL */
    menuLeftItems.forEach(item => {
        item.addEventListener("mouseenter", () => {
            const catId = item.dataset.catId;
            const catName = item.querySelector("span").textContent;
            updateCategory(catId, catName);
        });
    });

    /* CLICK → mode étendu */
    menuLeftItems.forEach(item => {
        item.addEventListener("click", () => {
            menuContainer.classList.add("expanded");
            const catId = item.dataset.catId;
            const catName = item.querySelector("span").textContent;
            updateCategory(catId, catName);
        });
    });

});
document.addEventListener("DOMContentLoaded", () => {
    const panel = document.getElementById("taillePanel");
    if (!panel) return; // sécurité
    const closeBtn = panel.querySelector(".close-btn");
    const body = document.body;

    // --- Ouvrir le panel au clic sur une taille disponible ---
    document.querySelectorAll('.taille-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!btn.classList.contains('out-of-stock')) {
                panel.classList.add('open');
                body.style.overflow = "hidden"; // désactive le scroll derrière
            }
        });
    });

    // --- Fermer le panel ---
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            panel.classList.remove('open');
            body.style.overflow = ""; // réactive le scroll
        });
    }

    // --- Supprimer flèches des inputs number ---
    document.querySelectorAll('.qty').forEach(input => {
        input.style.MozAppearance = 'textfield';
        input.style.WebkitAppearance = 'none';
        input.style.margin = 0;
    });

    // --- Gestion des boutons + / - ---
    document.querySelectorAll(".option-actions").forEach(box => {
        const minusBtn = box.querySelector(".minus");
        const plusBtn = box.querySelector(".plus");
        const qtyInput = box.querySelector(".qty");
        const max = parseInt(qtyInput?.max) || Infinity;

        minusBtn?.addEventListener("click", () => {
            let value = parseInt(qtyInput.value) || 0;
            if (value > 0) qtyInput.value = value - 1;
        });

        plusBtn?.addEventListener("click", () => {
            let value = parseInt(qtyInput.value) || 0;
            if (value < max) qtyInput.value = value + 1;
        });
    });

    // --- Ajouter plusieurs tailles au panier ---
    const addAllBtn = document.getElementById('add-all-to-cart');
    addAllBtn?.addEventListener('click', async (e) => {
        const produitId = e.currentTarget.dataset.id;
        const selections = [];

        document.querySelectorAll(".option-actions").forEach(box => {
            const qtyInput = box.querySelector(".qty");
            const pivotIdInput = box.querySelector(".pivot-id");
            const quantity = parseInt(qtyInput?.value) || 0;

            if (quantity > 0 && pivotIdInput) {
                selections.push({
                    pivotId: pivotIdInput.value,
                    quantity: quantity
                });
            }
        });

        if (selections.length === 0) {
            alert("Veuillez sélectionner au moins une taille et quantité.");
            return;
        }

        for (let item of selections) {
            try {
                const res = await fetch('/panier/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        produit_id: produitId,
                        produit_valeur_attribut_id: item.pivotId,
                        quantity: item.quantity
                    })
                });
                const data = await res.json();
                console.log("Ajout OK :", data);
            } catch (err) {
                console.error("Erreur :", err);
            }
        }

        panel.classList.remove('open');
        body.style.overflow = "";
    });
});
