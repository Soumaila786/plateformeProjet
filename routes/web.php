<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Page d'accueil
Route::get('/', function () { return view('accueil');})->name('accueil');
Route::post('/contact', [ContactController::class, 'envoyer'])->name('contact.envoyer');

// Authentification
require __DIR__.'/auth.php';

// Routes protégées
Route::middleware('auth')->group(function () {
    require __DIR__.'/modules/admin.php';
    require __DIR__.'/modules/porteur.php';
    require __DIR__.'/modules/approbateur.php';
    require __DIR__.'/modules/validateur.php';
    require __DIR__.'/modules/planificateur.php';
    require __DIR__.'/modules/parametres.php';
    require __DIR__.'/modules/notifications.php';
});
