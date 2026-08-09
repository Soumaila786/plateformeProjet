<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Validateur\DashboardController as ValidateurDashboardController;
use App\Http\Controllers\Validateur\ProjetController as ValidateurProjetController;
use App\Http\Controllers\NotificationController;

Route::prefix('validation')->name('validateur.')->middleware(['auth', 'role:validateur'])->group(function () {
        Route::get('/dashboard',[ValidateurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytique',[App\Http\Controllers\Validateur\AnalytiqueController::class, 'index'])->name('analytique');
        // Projets
        Route::get('/projets/mes_projets',[ValidateurProjetController::class, 'mesProjets'])->name('projets.mes_projets');
        Route::get('/projets', [ValidateurProjetController::class, 'index'])->name('projets.index');
        Route::get('/projets/{projet}',[ValidateurProjetController::class, 'show'])->name('projets.show');
        Route::post('/projets/{projet}/valider', [ValidateurProjetController::class, 'valider'])->name('projets.valider');
        Route::post('/projets/{projet}/rejeter',[ValidateurProjetController::class, 'rejeter'])->name('projets.rejeter');
        Route::post('/projets/{projet}/demande-modification',[ValidateurProjetController::class, 'demanderModification'])->name('projets.demande-modification');
        // Notifications
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues',[NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete( '/notifications/lues', [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}',[NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
