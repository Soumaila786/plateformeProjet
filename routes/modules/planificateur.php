<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Planificateur\DashboardController as PlanificateurDashboardController;
use App\Http\Controllers\Planificateur\PlanificationController as PlanificateurPlanificationController;
use App\Http\Controllers\NotificationController;

Route::middleware('role:planificateur')->prefix('planification')->name('planificateur.')->group(function () {

        Route::get('/dashboard',[PlanificateurDashboardController::class, 'index'])->name('dashboard');

        // Projets avec demande de planification
        Route::get('/projets/traites',[PlanificateurPlanificationController::class, 'traites'])->name('projets.traites');
        Route::get('/projets',[PlanificateurPlanificationController::class, 'index'])->name('projets.index');
        Route::get('/projets/{projet}', [PlanificateurPlanificationController::class, 'show'])->name('projets.show');

        // CRUD planification
        Route::get('/projets/{projet}/planifications/creer',[PlanificateurPlanificationController::class, 'create'])->name('planifications.create');
        Route::post('/projets/{projet}/planifications',[PlanificateurPlanificationController::class, 'store'])->name('planifications.store');
        Route::get('/projets/{projet}/planifications/{planification}/modifier',[PlanificateurPlanificationController::class, 'edit'])
            ->name('planifications.edit');
        Route::put('/projets/{projet}/planifications/{planification}',[PlanificateurPlanificationController::class, 'update'])
            ->name('planifications.update');
        Route::delete('/projets/{projet}/planifications/{planification}',[PlanificateurPlanificationController::class, 'destroy'])
            ->name('planifications.destroy');

        // Notifications
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues',[NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',[NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}',[NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
