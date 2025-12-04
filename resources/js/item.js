document.addEventListener("DOMContentLoaded", () => {
    const subtotalEl = document.getElementById("subtotal");
    const shippingSelect = document.getElementById("shippingSelect");
    const shippingCostEl = document.getElementById("shippingCost");
    const totalEl = document.getElementById("total");
    const freeMessage = document.getElementById("freeShippingMessage");
    const checkoutBtn = document.getElementById('checkoutBtn');
    const checkoutModal = document.getElementById('checkoutModal');
    const checkoutOverlay = document.getElementById('checkoutOverlay');
    function formatMoney(n) {
        return new Intl.NumberFormat("fr-FR").format(n);
    }

    function updateTotals() {
        const subtotal = parseInt(subtotalEl.textContent.replace(/\s/g, ''));
        const selectedShipping = parseInt(shippingSelect.value);

        let shippingCost = selectedShipping;

        // 🚀 Livraison gratuite si condition remplie
        if (subtotal >= FREE_LIMIT) {
            shippingCost = 0;
            shippingCostEl.textContent = "GRATUIT";
            freeMessage.textContent = "Livraison GRATUITE activée 🎉";
        } else {
            shippingCostEl.textContent = formatMoney(selectedShipping) + " FCFA";
            const remaining = FREE_LIMIT - subtotal;
            freeMessage.innerHTML =
                `Dépensez encore <b>${formatMoney(remaining)} FCFA</b> pour obtenir la <b>livraison GRATUITE</b>`;
        }

        const total = subtotal + shippingCost;
        totalEl.textContent = formatMoney(total) + " FCFA";
    }

    shippingSelect.addEventListener("change", updateTotals);

    // premier calcul
    updateTotals();
});

checkoutBtn.addEventListener('click', () => {
    checkoutOverlay.style.display = 'block';
    checkoutModal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // bloque scroll
});

checkoutOverlay.addEventListener('click', () => {
    checkoutOverlay.style.display = 'none';
    checkoutModal.style.display = 'none';
    document.body.style.overflow = 'auto';
});

