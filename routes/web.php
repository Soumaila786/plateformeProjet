<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () { return view('accueil');});

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
