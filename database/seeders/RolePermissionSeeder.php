<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Vider le cache de permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ══════════════════════════════════════
        // PERMISSIONS
        // ══════════════════════════════════════

        $permissions = [
            // Utilisateurs
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.toggle-status',

            // Secteurs
            'secteurs.view',
            'secteurs.create',
            'secteurs.edit',
            'secteurs.delete',
            'secteurs.toggle-status',

            // Projets — lecture
            'projets.view',
            'projets.view-all',       // voir tous les projets
            'projets.view-own',       // voir seulement ses projets

            // Projets — écriture
            'projets.create',
            'projets.edit',
            'projets.edit-own',       // modifier seulement ses projets
            'projets.delete',
            'projets.delete-own',     // supprimer seulement si pas approuvé/validé

            // Projets — actions de statut
            'projets.soumettre',
            'projets.examiner',
            'projets.approuver',
            'projets.rejeter',
            'projets.valider',
            'projets.demande-modification',

            // Documents
            'documents.view',
            'documents.upload',
            'documents.delete',
            'documents.delete-own',
            'documents.download',

            // Activite
            // 'activites.view',
            // 'activites.create',
            // 'activites.edit',
            // 'activites.delete',

            // Dashboard
            'dashboard.admin',
            'dashboard.porteur',
            'dashboard.approbateur',
            'dashboard.validateur',

            // Paramètres
            'parametres.system',      // paramètres système (admin uniquement)
            'parametres.profil',      // tous les rôles
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ══════════════════════════════════════
        // RÔLES ET ATTRIBUTION DES PERMISSIONS
        // ══════════════════════════════════════

        // ── Admin ──
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'users.view', 'users.create', 'users.edit', 'users.delete', 'users.toggle-status',
            'secteurs.view', 'secteurs.create', 'secteurs.edit', 'secteurs.delete', 'secteurs.toggle-status',
            'projets.view', 'projets.view-all',
            'documents.view', 'documents.download',
            'activites.view',
            'dashboard.admin',
            'parametres.system', 'parametres.profil',
        ]);

        // ── Porteur ──
        $porteur = Role::firstOrCreate(['name' => 'porteur']);
        $porteur->syncPermissions([
            'projets.view', 'projets.view-own',
            'projets.create', 'projets.edit-own', 'projets.delete-own',
            'projets.soumettre',
            'documents.view', 'documents.upload', 'documents.delete-own', 'documents.download',
            'activites.view', 'activites.create', 'activites.delete',
            'dashboard.porteur',
            'parametres.profil',
        ]);

        // ── Approbateur ──
        $approbateur = Role::firstOrCreate(['name' => 'approbateur']);
        $approbateur->syncPermissions([
            // Comme porteur pour ses propres projets
            'projets.view', 'projets.view-own', 'projets.view-all',
            'projets.create', 'projets.edit-own', 'projets.delete-own',
            'projets.soumettre',
            // Actions d'approbateur
            'projets.examiner', 'projets.approuver', 'projets.rejeter',
            'projets.demande-modification',
            'documents.view', 'documents.upload', 'documents.delete-own', 'documents.download',
            'activites.view', 'activites.create', 'activites.edit', 'activites.delete',
            'dashboard.approbateur',
            'parametres.profil',
        ]);

        // ── Validateur ──
        $validateur = Role::firstOrCreate(['name' => 'validateur']);
        $validateur->syncPermissions([
            'projets.view', 'projets.view-all',
            'projets.valider', 'projets.rejeter',
            'documents.view', 'documents.download',
            'activites.view',
            'dashboard.validateur',
            'parametres.profil',
        ]);

        // ══════════════════════════════════════
        // ASSIGNER LE RÔLE SPATIE AUX USERS EXISTANTS
        // selon le champ 'role' déjà en BDD
        // ══════════════════════════════════════
        User::all()->each(function ($user) {
            if ($user->role && !$user->hasRole($user->role)) {
                $user->assignRole($user->role);
            }
        });

        $this->command->info('Rôles et permissions créés avec succès.');
    }
}
