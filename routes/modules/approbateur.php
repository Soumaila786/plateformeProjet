<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Approbateur\DashboardController as ApprobateurDashboardController;
use App\Http\Controllers\Approbateur\ProjetController as ApprobateurProjetController;
use App\Http\Controllers\Approbateur\ExportController as ApprobateurExportController;
use App\Http\Controllers\NotificationController;

Route::middleware('role:approbateur')->prefix('examen')->name('approbateur.')->group(function () {

        Route::get('/dashboard',[ApprobateurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytique',[App\Http\Controllers\Approbateur\AnalytiqueController::class, 'index'])->name('analytique');
        // Mes projets traités
        Route::get('projets/mes_projets',[ApprobateurProjetController::class, 'mesProjets'])->name('projets.mes_projets');
        // Projets à examiner/approuver/rejeter
        Route::get('projets',[ApprobateurProjetController::class, 'index'])->name('projets.index');
        Route::get('projets/{projet}',[ApprobateurProjetController::class, 'show'])->name('projets.show');
        Route::post('projets/{projet}/examiner',[ApprobateurProjetController::class, 'examiner'])->name('projets.examiner');
        Route::post('projets/{projet}/approuver',[ApprobateurProjetController::class, 'approuver'])->name('projets.approuver');
        Route::post('projets/{projet}/rejeter',[ApprobateurProjetController::class, 'rejeter'])->name('projets.rejeter');
        Route::post('projets/{projet}/demande-modification',[ApprobateurProjetController::class, 'demanderModification'])
            ->name('projets.demande-modification');
        Route::post('projets/{projet}/activites/{activites}/statut',[ApprobateurProjetController::class, 'changerStatutActivite'])
            ->name('projets.activite.statut');
        // Documents
        Route::get('projets/{projet}/documents/{document}/download',[ApprobateurProjetController::class, 'downloadDocument'])
            ->name('projets.documents.download');
        // Export du projet
        Route::get('/projets/{projet}/export/pdf',[ApprobateurExportController::class, 'exportPdf'])->name('projets.export.pdf');
        // Notifications
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',[NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}',[NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
