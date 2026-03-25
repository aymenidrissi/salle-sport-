<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NutritionTipController as AdminNutritionTipController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NutritionController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ProgramController as ClientProgramController;
use App\Http\Controllers\Client\ProgressController;
use App\Http\Controllers\Client\VideoController as ClientVideoController;
use Illuminate\Support\Facades\Route;

// Entrée client (toutes les URLs client passent sous /client)
Route::redirect('/', '/client');

Route::prefix('client')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('client.home');

    Route::get('/a-propos', [HomeController::class, 'about'])->name('client.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('client.contact');

    Route::get('/programmes', [ClientProgramController::class, 'index'])->name('client.programs.index');
    Route::get('/programmes/{program}', [ClientProgramController::class, 'show'])->name('client.programs.show');

    Route::get('/videos/{video}', [ClientVideoController::class, 'show'])->name('client.videos.show');

    Route::get('/nutrition', [NutritionController::class, 'index'])->name('client.nutrition.index');

    Route::middleware('auth')->group(function () {
        Route::get('/espace', [ClientDashboardController::class, 'index'])->name('client.dashboard');
        Route::get('/profil', [ProfileController::class, 'show'])->name('client.profile');
        Route::put('/profil', [ProfileController::class, 'update'])->name('client.profile.update');

        Route::get('/progression', [ProgressController::class, 'index'])->name('client.progress.index');
        Route::post('/progression', [ProgressController::class, 'store'])->name('client.progress.store');
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

    Route::resource('users', AdminUserController::class);
    Route::resource('programs', AdminProgramController::class);
    Route::resource('videos', AdminVideoController::class);
    Route::resource('nutrition-tips', AdminNutritionTipController::class);
});
