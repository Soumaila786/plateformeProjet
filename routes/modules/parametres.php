<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametreController;

Route::middleware(['auth'])->prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/',              [ParametreController::class, 'index'])->name('index');
        Route::get('/profil',        [ParametreController::class, 'profil'])->name('profil');
        Route::put('/profil',        [ParametreController::class, 'profilUpdate'])->name('profil.update');
        Route::get('/securite',      [ParametreController::class, 'securite'])->name('securite');
        Route::put('/securite',      [ParametreController::class, 'securiteUpdate'])->name('securite.update');
        Route::get('/notifications', [ParametreController::class, 'notifications'])->name('notifications');
        Route::put( '/notifications',[ParametreController::class, 'notificationsUpdate'])->name('notifications.update');
        Route::get('/general',       [ParametreController::class, 'general'])->name('general');
        Route::put('/general',       [ParametreController::class, 'generalUpdate'])->name('general.update');
    });
