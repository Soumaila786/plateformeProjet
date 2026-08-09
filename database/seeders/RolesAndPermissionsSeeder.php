<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder {

    public function run() {
        
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Toutes les permissions de l'application, regroupées par domaine ──
        $permissions = [
            // Projets
            'projets.creer',
            'projets.voir',
            'projets.modifier',
            'projets.supprimer',
            'projets.soumettre',
            'projets.examiner',
            'projets.approuver',
            'projets.rejeter',
            'projets.valider',
            'projets.demander_modification',
            'projets.gerer_activite',
            'projets.gerer_planification',
            'projets.voir_planification',

            // Documents
            'documents.upload',
            'documents.supprimer',

            // Administration
            'utilisateurs.gerer',
            'secteurs.gerer',
            'motifs.gerer',
            'configurations.gerer',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ── Rôles et leurs permissions ──
        $roles = [
            // Admin : toutes les permissions
            'admin' => $permissions,

            'porteur' => [
                'projets.creer',
                'projets.voir',
                'projets.modifier',
                'projets.supprimer',
                'projets.soumettre',
                'projets.gerer_activite',
                'projets.gerer_planification',
                'projets.voir_planification',
                'documents.upload',
                'documents.supprimer',
            ],

            'approbateur' => [
                'projets.voir',
                'projets.examiner',
                'projets.approuver',
                'projets.rejeter',
                'projets.demander_modification',
                'projets.voir_planification',
            ],

            'validateur' => [
                'projets.voir',
                'projets.valider',
                'projets.rejeter',
                'projets.demander_modification',
                'projets.voir_planification',
            ],

            'planificateur' => [
                'projets.voir',
                'projets.gerer_planification',
                'projets.voir_planification',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }
}
