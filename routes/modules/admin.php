<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecteurController;
use App\Http\Controllers\Admin\ProjetController;
use App\Http\Controllers\Admin\MotifRejetController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\NotificationController;

Route::middleware('role:admin')->prefix('gestion')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytique', [App\Http\Controllers\Admin\AnalytiqueController::class,'index'])->name('analytique');
        // Utilisateurs
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status',[UserController::class, 'toggleStatus'])->name('users.toggle-status');
        // Secteurs
        Route::resource('secteurs', SecteurController::class);
        Route::post('secteurs/{secteur}/toggle-status',[SecteurController::class, 'toggleStatus'])->name('secteurs.toggle-status');
        // Motifs de rejet / demande de modification
        Route::get('motifs',[MotifRejetController::class, 'index'])->name('motifs.index');
        Route::post('motifs',[MotifRejetController::class, 'store'])->name('motifs.store');
        Route::put('motifs/{motif}',[MotifRejetController::class, 'update'])->name('motifs.update');
        Route::delete('motifs/{motif}',[MotifRejetController::class, 'destroy'])->name('motifs.destroy');
        Route::post('motifs/{motif}/toggle-status',[MotifRejetController::class, 'toggleStatus'])->name('motifs.toggle-status');
        // Projets
        Route::resource('projets', ProjetController::class)->only(['index', 'show', 'destroy']);
        // Documents
        Route::delete('projets/{projet}/documents/{document}', [ProjetController::class, 'destroyDocument'])->name('projets.documents.destroy');
        Route::get('projets/{projet}/documents/{document}/download',[ProjetController::class, 'downloadDocument'])->name('projets.documents.download');
        // Configuration du système
        Route::get('/configuration',[App\Http\Controllers\Admin\ConfigurationController::class, 'index'])->name('configuration.index');
        Route::put('/configuration',[App\Http\Controllers\Admin\ConfigurationController::class, 'update'])->name('configuration.update');
        Route::post('/configuration/{cle}/reset',[App\Http\Controllers\Admin\ConfigurationController::class, 'reset'])->name('configuration.reset');
        // Les logs
        Route::get('/logs',[LogController::class, 'index'])->name('logs.index');
        // Notifications
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues',[NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',[NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}',[NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
