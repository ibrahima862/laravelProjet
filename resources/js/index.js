// ===============================
// NAVIGATION VERS PAGE PRODUIT
// ===============================
document.querySelectorAll('.view-product').forEach(button => {
    button.addEventListener('click', () => {
        const slug = button.dataset.slug;
        window.location.href = `/produit/${slug}`;
    });
});


// ===============================
// MENU GAUCHE : OUVERTURE CATÉGORIES
// ===============================
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

    // Afficher les bons produits
    productSections.forEach(section => {
        section.classList.toggle("active", section.dataset.catId === catId);
    });

    // Activer sur left menu
    menuLeftItems.forEach(i => i.classList.remove('active'));
    document.querySelector(`.menu-item[data-cat-id="${catId}"]`)
        .classList.add('active')
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
      