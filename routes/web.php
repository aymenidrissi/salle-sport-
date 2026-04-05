<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NutritionTipController as AdminNutritionTipController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\CategoryProductController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NutritionController;
use App\Http\Controllers\Client\NutritionTipRequestController as ClientNutritionTipRequestController;
use App\Http\Controllers\Client\ProduitController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ProgramController as ClientProgramController;
use App\Http\Controllers\Client\ProgressController;
use App\Http\Controllers\Client\VideoController as ClientVideoController;
use Illuminate\Support\Facades\Route;

// Fiche « produit » (URL type boutique, hors préfixe /client)
Route::redirect('/produit/programme-debutant-femme', '/produit/debutant-femme', 301);
Route::redirect('/debutant-femme', '/produit/debutant-femme', 301);
Route::get('/produit/{program:slug}', [ProduitController::class, 'show'])->name('client.product.show');
Route::get('/categorie-produit/{category}', [CategoryProductController::class, 'show'])->name('client.category-products.show');

// Entrée client (toutes les URLs client passent sous /client)
Route::redirect('/', '/client');

Route::prefix('client')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('client.home');

    Route::get('/a-propos', [HomeController::class, 'about'])->name('client.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('client.contact');

    Route::view('/panier', 'client.cart.index')->name('client.cart');
    Route::view('/paiement', 'client.checkout.index')->name('client.checkout');
    Route::post('/paiement', [CheckoutController::class, 'store'])->name('client.checkout.store');

    Route::get('/programmes', [ClientProgramController::class, 'index'])->name('client.programs.index');
    Route::get('/programmes/{program}', [ClientProgramController::class, 'show'])->name('client.programs.show');

    Route::get('/videos/{video}', [ClientVideoController::class, 'show'])->name('client.videos.show');

    Route::get('/nutrition', [NutritionController::class, 'index'])->name('client.nutrition.index');

    // Profil : la page est accessible à tous (formulaire invité + édition connecté) ; seule la mise à jour exige une session.
    Route::get('/profil', [ProfileController::class, 'show'])->name('client.profile');

    Route::middleware('auth')->group(function () {
        Route::get('/espace', [ClientDashboardController::class, 'index'])->name('client.dashboard');
        Route::put('/profil', [ProfileController::class, 'update'])->name('client.profile.update');

        Route::get('/progression', [ProgressController::class, 'index'])->name('client.progress.index');
        Route::post('/progression', [ProgressController::class, 'store'])->name('client.progress.store');

        Route::post('/nutrition-tip-requests', [ClientNutritionTipRequestController::class, 'store'])->name('client.nutrition-tip-requests.store');
    });
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{order}/approve', [SubscriptionController::class, 'approve'])->name('subscriptions.approve');

    Route::post('/programs/cart-requests/{orderItem}/assign', [AdminProgramController::class, 'assignCartRequest'])->name('programs.cart-requests.assign');

    Route::resource('users', AdminUserController::class);
    Route::resource('programs', AdminProgramController::class);
    Route::resource('videos', AdminVideoController::class);
    Route::resource('nutrition-tips', AdminNutritionTipController::class);
});
