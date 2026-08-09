<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Porteur\DashboardController as PorteurDashboardController;
use App\Http\Controllers\Porteur\ProjetController as PorteurProjetController;
use App\Http\Controllers\Porteur\PlanificationController as PorteurPlanificationController;
use App\Http\Controllers\NotificationController;

Route::middleware('role:porteur')->prefix('mes-projets')->name('porteur.')->group(function () {

        Route::get('/dashboard',[PorteurDashboardController::class, 'index'])->name('dashboard');
        
        // Projets
        Route::get('projets',[PorteurProjetController::class, 'index'])->name('projets.index');
        Route::get('projets/creer',[PorteurProjetController::class, 'create'])->name('projets.create');
        Route::post('projets', [PorteurProjetController::class, 'store'])->name('projets.store');
        Route::get('projets/{projet}',[PorteurProjetController::class, 'show'])->name('projets.show');
        Route::get('projets/{projet}/modifier',[PorteurProjetController::class, 'edit'])->name('projets.edit');
        Route::put('projets/{projet}',[PorteurProjetController::class, 'update'])->name('projets.update');
        Route::delete('projets/{projet}',[PorteurProjetController::class, 'destroy'])->name('projets.destroy');

        // Soumettre
        Route::post('projets/{projet}/soumettre',[PorteurProjetController::class, 'soumettre'])->name('projets.soumettre');

        // Demande de planification
        Route::post('projets/{projet}/planification',[PorteurProjetController::class, 'demanderPlanification'])->name('demande.planification');

        // Documents
        Route::post('projets/{projet}/documents',[PorteurProjetController::class, 'storeDocument'])->name('projets.documents.store');
        Route::delete('projets/{projet}/documents/{document}',[PorteurProjetController::class, 'destroyDocument'])
            ->name('projets.documents.destroy');
        Route::get('projets/{projet}/documents/{document}/download',[PorteurProjetController::class, 'downloadDocument'])
            ->name('projets.documents.download');

        // Activités (planification)
        Route::get('projets/{projet}/planifications/creer',[PorteurPlanificationController::class, 'create'])->name('planifications.create');
        Route::post('projets/{projet}/planifications',[PorteurPlanificationController::class, 'store'])->name('planifications.store');
        Route::get('projets/{projet}/planifications/{planification}/modifier', [PorteurPlanificationController::class, 'edit'])
            ->name('planifications.edit');
        Route::put('projets/{projet}/planifications/{planification}',[PorteurPlanificationController::class, 'update'])
            ->name('planifications.update');
        Route::delete('projets/{projet}/planifications/{planification}',[PorteurPlanificationController::class, 'destroy'])
            ->name('planifications.destroy');

        // Notifications
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues',[NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',[NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}',[NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
