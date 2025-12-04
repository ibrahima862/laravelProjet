import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
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

document.querySelectorAll('.view-product').forEach(button => {
    button.addEventListener('click', function () {
        const slug = this.dataset.slug;
        window.location.href = `/produit/${slug}`;
    });
});
const hamburger = document.querySelector('.hamburger');
const dropdown = document.querySelector('.menu-dropdown');

// Fonction pour ouvrir le menu
function openMenu() {
    dropdown.classList.add('active');
    document.body.classList.add('no-scroll'); // facultatif
}

function closeMenu() {
    dropdown.classList.remove('active');
    document.body.classList.remove('no-scroll'); // facultatif
}

// Hover sur le bouton
hamburger.addEventListener('mouseenter', openMenu);
// Hover sur le menu pour rester ouvert
dropdown.addEventListener('mouseenter', openMenu);


// Quand la souris quitte le menu ou le bouton
hamburger.addEventListener('mouseleave', () => {
    setTimeout(() => {
        if (!dropdown.matches(':hover')) closeMenu();
    }, 200); // 200ms pour plus de tolérance
});

dropdown.addEventListener('mouseleave', closeMenu);
const menuItems = document.querySelectorAll('.menu-item');
const productSections = document.querySelectorAll('.products-section');

menuItems.forEach(item => {
    item.addEventListener('click', () => {
        const catId = item.getAttribute('data-cat-id');

        productSections.forEach(section => {
            if (section.getAttribute('data-cat-id') === catId) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const panel = document.getElementById("taillePanel");
    const closeBtn = panel.querySelector(".close-btn");

    // Ouverture seulement si taille disponible
    document.querySelectorAll('.taille-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!btn.classList.contains('out-of-stock')) {
                panel.classList.add('open'); // Ouvre le panel
                body.style.overflow = "hidden";
            }
        });
    });

    // Fermeture
    closeBtn.addEventListener('click', () => {
        panel.classList.remove('open');
    });


    // --- Fermeture du panel ---
    closeBtn?.addEventListener('click', () => panel?.classList.remove('open'));

    // --- Supprimer flèches natives sur input type=number ---
    document.querySelectorAll('.qty').forEach(input => {
        input.style.MozAppearance = 'textfield';
        input.style.WebkitAppearance = 'none';
        input.style.margin = 0;
    });

    // --- Gestion boutons + et - pour chaque taille ---
    document.querySelectorAll(".option-actions").forEach(box => {
        const minusBtn = box.querySelector(".minus");
        const plusBtn = box.querySelector(".plus");
        const qtyInput = box.querySelector(".qty");
        const max = parseInt(qtyInput.max) || Infinity;

        minusBtn.addEventListener("click", () => {
            let value = parseInt(qtyInput.value) || 0;
            if (value > 0) qtyInput.value = value - 1;
        });

        plusBtn.addEventListener("click", () => {
            let value = parseInt(qtyInput.value) || 0;
            if (value < max) qtyInput.value = value + 1;
        });
    });

    // --- Bouton général "Ajouter au panier" ---
    const addAllBtn = document.getElementById('add-all-to-cart');
    if (addAllBtn) {
        addAllBtn.addEventListener('click', (e) => {
            const produitId = e.currentTarget.dataset.id;
            const selections = [];

            document.querySelectorAll(".option-actions").forEach(box => {
                const qtyInput = box.querySelector(".qty");
                const pivotIdInput = box.querySelector(".pivot-id");
                const quantity = parseInt(qtyInput.value) || 0;

                if (quantity > 0) {
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

            selections.forEach(item => {
                fetch('/panier/add', {
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
                })
                    .then(res => res.json())
                    .then(data => console.log("Ajout OK :", data))
                    .catch(err => console.error("Erreur :", err));
            });

            panel?.classList.remove('open'); // Fermer après ajout
        });
    }
});
