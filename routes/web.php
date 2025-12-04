
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AttributController;
use App\Http\Controllers\SearchController;

Route::get('/ff', function () {
    return view('auth/register');
});
Route::get('/register', function () {
    return view('auth/register');
})->name('register');

// Page principale
Route::get('/', [ProduitController::class, 'index'])->name('index.home');
Route::get('/mes-commandes', [CommandeController::class, 'index'])->name('commandes.index');
// Admin commandes
Route::prefix('admin')->middleware('auth')->group(function () {
    // Liste de toutes les commandes
    Route::get('/commandes', [\App\Http\Controllers\AdminCommandeController::class, 'index'])
        ->name('admin.commandes.index');

    // Détail d’une commande
    Route::get('/commandes/{id}', [\App\Http\Controllers\AdminCommandeController::class, 'show'])
        ->name('admin.commandes.show');

    // Changer le statut
    Route::put('/commandes/{id}/status', [\App\Http\Controllers\AdminCommandeController::class, 'updateStatus'])
        ->name('admin.commandes.updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});
Route::get('/account', [NotificationController::class, 'index'])->name('account');


Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Route pour afficher une commande individuelle
Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
Route::put('/commandes/{id}/cancel', [CommandeController::class, 'cancel'])
    ->name('commandes.cancel');

// Checkout
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Produits
Route::get("/Allproduit", [ProduitController::class, 'showAll'])->name('Allproduits.index');
Route::get('/produit/{slug}', [ProduitController::class, 'show'])->name('produit.show');

// Panier
Route::get('/item', [PanierController::class, 'index'])->name('panier.index');
Route::get('/panier/badge', [PanierController::class, 'badge'])->name('panier.badge');
Route::post('/panier/add', [PanierController::class, 'add'])->name('panier.add');
// Création produits
Route::get('/produits', [ProduitController::class, 'create'])->name('produits.create');
Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
Route::get('/admin/categorie/{id}/attributs', [AttributController::class, 'getByCategorie']);

// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
