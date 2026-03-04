<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecteurController;
use App\Http\Controllers\Admin\ProjetController;

// Routes de connexion
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // === ROUTES COMMUNES À TOUS LES UTILISATEURS ===
    Route::middleware(['auth'])->group(function () {
    // Paramètres communs
    Route::prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/', function () {
            return view('parametres.index');
        })->name('index');
        
        // Profil
        Route::get('/profil', function () {
            return view('parametres.profil');
        })->name('profil');
        Route::put('/profil', function () {
            // Logique de mise à jour
            return redirect()->route('parametres.index')->with('success', 'Profil mis à jour');
        })->name('profil.update');
        
        // Sécurité
        Route::get('/securite', function () {
            return view('parametres.securite');
        })->name('securite');
        Route::put('/securite', function () {
            // Logique de mise à jour du mot de passe
            return redirect()->route('parametres.index')->with('success', 'Mot de passe mis à jour');
        })->name('securite.update');
        
        // Notifications
        Route::get('/notifications', function () {
            return view('parametres.notifications');
        })->name('notifications');
        Route::put('/notifications', function () {
            return redirect()->route('parametres.index')->with('success', 'Préférences mises à jour');
        })->name('notifications.update');
        
        // Général
        Route::get('/general', function () {
            return view('parametres.general');
        })->name('general');
        Route::put('/general', function () {
            return redirect()->route('parametres.index')->with('success', 'Paramètres généraux mis à jour');
        })->name('general.update');
    });
});

    // === ROUTES ADMIN ===
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Gestion des secteurs
        Route::resource('secteurs', SecteurController::class);
        Route::post('/secteurs/{secteur}/toggle-status', [SecteurController::class, 'toggleStatus'])->name('secteurs.toggle-status');
        
        // Gestion des projets
        Route::resource('projets', ProjetController::class);
 
        // Notifications admin
        Route::get('/notifications', function () {
            return view('admin.notifications.index');
        })->name('notifications.index');
    });

    // === ROUTES APPROBATEUR ===
    Route::prefix('approbateur')->name('approbateur.')->group(function () {
        Route::get('/dashboard', function () {
            return view('approbateur.dashboard');
        })->name('dashboard');
    });

    // === ROUTES VALIDATEUR ===
    Route::prefix('validateur')->name('validateur.')->group(function () {
        Route::get('/dashboard', function () {
            return view('validateur.dashboard');
        })->name('dashboard');
    });

    // === ROUTES PORTEUR ===
    Route::prefix('porteur')->name('porteur.')->group(function () {
        Route::get('/dashboard', function () {
            return view('porteur.dashboard');
        })->name('dashboard');
    });

});