<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecteurController;
use App\Http\Controllers\Admin\ProjetController;
use App\Http\Controllers\Admin\PlanificationController;
use App\Http\Controllers\ParametreController;


// Porteur
use App\Http\Controllers\Porteur\DashboardController      as PorteurDashboardController;
use App\Http\Controllers\Porteur\ProjetController         as PorteurProjetController;
use App\Http\Controllers\Porteur\PlanificationController  as PorteurPlanificationController;

// Approbateur
use App\Http\Controllers\Approbateur\DashboardController  as ApprobateurDashboardController;
use App\Http\Controllers\Approbateur\ProjetController     as ApprobateurProjetController;

// Validateur
use App\Http\Controllers\Validateur\DashboardController   as ValidateurDashboardController;
use App\Http\Controllers\Validateur\ProjetController      as ValidateurProjetController;

// Notifications (partagé)
use App\Http\Controllers\NotificationController;

// ============================================================== ROUTES PUBLIQUES (non connecté)==============================================================

Route::middleware('guest')->group(function () {
    Route::get('/',       [LoginController::class, 'showLoginForm']);
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

//  ============================================================== ROUTES PROTÉGÉES ==============================================================

Route::middleware(['auth'])->group(function () {

    // ── Paramètres communs à tous les rôles ──
    Route::middleware(['auth'])->prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/',             [ParametreController::class, 'index'])               ->name('index');
        Route::get('/profil',       [ParametreController::class, 'profil'])              ->name('profil');
        Route::put('/profil',       [ParametreController::class, 'profilUpdate'])        ->name('profil.update');
        Route::get('/securite',     [ParametreController::class, 'securite'])            ->name('securite');
        Route::put('/securite',     [ParametreController::class, 'securiteUpdate'])      ->name('securite.update');
        Route::get('/notifications',[ParametreController::class, 'notifications'])       ->name('notifications');
        Route::put('/notifications',[ParametreController::class, 'notificationsUpdate']) ->name('notifications.update');
        Route::get('/general',      [ParametreController::class, 'general'])             ->name('general');
        Route::put('/general',      [ParametreController::class, 'generalUpdate'])       ->name('general.update');
    });


    // =========================================================== ADMINISTRATEUR ==============================================================

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytique',  [App\Http\Controllers\Admin\AnalytiqueController::class, 'index'])->name('analytique');


        // Utilisateurs
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        // Secteurs
        Route::resource('secteurs', SecteurController::class);
        Route::post('secteurs/{secteur}/toggle-status', [SecteurController::class, 'toggleStatus'])
            ->name('secteurs.toggle-status');

        // Projets
        Route::resource('projets', ProjetController::class)->only(['index', 'show', 'destroy']);
        Route::post('projets/{projet}/statut', [ProjetController::class, 'changerStatut'])
            ->name('projets.statut');

        // Documents
        Route::delete('projets/{projet}/documents/{document}', [ProjetController::class, 'destroyDocument'])
            ->name('projets.documents.destroy');
        Route::get('projets/{projet}/documents/{document}/download', [ProjetController::class, 'downloadDocument'])
            ->name('projets.documents.download');

        // Planifications
        Route::post('projets/{projet}/planifications', [PlanificationController::class, 'store'])
            ->name('projets.planifications.store');
        Route::delete('projets/{projet}/planifications/{planification}', [PlanificationController::class, 'destroy'])
            ->name('projets.planifications.destroy');

        // Notifications
        Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',      [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // ========================================================== PORTEUR ==============================================================

    Route::middleware('role:porteur')->prefix('porteur')->name('porteur.')->group(function () {

        Route::get('/dashboard', [PorteurDashboardController::class, 'index'])->name('dashboard');

        // Projets
        Route::get('projets',                    [PorteurProjetController::class, 'index'])->name('projets.index');
        Route::get('projets/creer',              [PorteurProjetController::class, 'create'])->name('projets.create');
        Route::post('projets',                   [PorteurProjetController::class, 'store'])->name('projets.store');
        Route::get('projets/{projet}',           [PorteurProjetController::class, 'show'])->name('projets.show');
        Route::get('projets/{projet}/modifier',  [PorteurProjetController::class, 'edit'])->name('projets.edit');
        Route::put('projets/{projet}',           [PorteurProjetController::class, 'update'])->name('projets.update');
        Route::delete('projets/{projet}',        [PorteurProjetController::class, 'destroy'])->name('projets.destroy');

        // Soumettre
        Route::post('projets/{projet}/soumettre', [PorteurProjetController::class, 'soumettre'])
            ->name('projets.soumettre');

        // Documents
        Route::post('projets/{projet}/documents', [PorteurProjetController::class, 'storeDocument'])
            ->name('projets.documents.store');
        Route::delete('projets/{projet}/documents/{document}', [PorteurProjetController::class, 'destroyDocument'])
            ->name('projets.documents.destroy');
        Route::get('projets/{projet}/documents/{document}/download', [PorteurProjetController::class, 'downloadDocument'])
            ->name('projets.documents.download');

        // Planifications
        Route::post('projets/{projet}/planifications', [PorteurPlanificationController::class, 'store'])
            ->name('projets.planifications.store');
        Route::delete('projets/{projet}/planifications/{planification}', [PorteurPlanificationController::class, 'destroy'])
            ->name('projets.planifications.destroy');

        // Notifications
        Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',      [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // ============================================================== APPROBATEUR ==============================================================

    Route::middleware('role:approbateur')->prefix('approbateur')->name('approbateur.')->group(function () {

        Route::get('/dashboard', [ApprobateurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytique', [App\Http\Controllers\Approbateur\AnalytiqueController::class, 'index'])->name('analytique');

        // Projets à examiner/approuver/rejeter
        Route::get('projets',              [ApprobateurProjetController::class, 'index'])->name('projets.index');
        Route::get('projets/{projet}',     [ApprobateurProjetController::class, 'show'])->name('projets.show');
        Route::post('projets/{projet}/examiner',  [ApprobateurProjetController::class, 'examiner'])->name('projets.examiner');
        Route::post('projets/{projet}/approuver', [ApprobateurProjetController::class, 'approuver'])->name('projets.approuver');
        Route::post('projets/{projet}/rejeter',   [ApprobateurProjetController::class, 'rejeter'])->name('projets.rejeter');
        Route::post('projets/{projet}/planifications/{planification}/statut', [ApprobateurProjetController::class, 'changerStatutActivite'])->name('projets.activite.statut');

        // Documents (lecture + téléchargement)
        Route::get('projets/{projet}/documents/{document}/download', [ApprobateurProjetController::class, 'downloadDocument'])
            ->name('projets.documents.download');

        // Mes projets traités
        Route::get('mes-projets', [ApprobateurProjetController::class, 'mesProjets'])
            ->name('mes-projets');

        // Notifications
        Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',      [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    
    // ============================================================== VALIDATEUR ==============================================================

    Route::prefix('validateur')->name('validateur.')->middleware(['auth', 'role:validateur'])->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Validateur\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/analytique',  [App\Http\Controllers\Validateur\AnalytiqueController::class, 'index'])->name('analytique');

        Route::get('/chart/bar',   [App\Http\Controllers\Validateur\DashboardController::class, 'chartBar'])->name('chart.bar');
        Route::get('/chart/line',  [App\Http\Controllers\Validateur\DashboardController::class, 'chartLine'])->name('chart.line');

        // Projets
        Route::get('/projets',                    [App\Http\Controllers\Validateur\ProjetController::class, 'index'])->name('projets.index');
        Route::get('/projets/{projet}',           [App\Http\Controllers\Validateur\ProjetController::class, 'show'])->name('projets.show');
        Route::post('/projets/{projet}/valider',  [App\Http\Controllers\Validateur\ProjetController::class, 'valider'])->name('projets.valider');
        Route::post('/projets/{projet}/rejeter',  [App\Http\Controllers\Validateur\ProjetController::class, 'rejeter'])->name('projets.rejeter');

        // Notifications
        Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
        Route::delete('/notifications/lues',      [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    });
});
