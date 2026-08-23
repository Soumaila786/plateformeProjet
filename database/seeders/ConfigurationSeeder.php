<?php
// database/seeders/ConfigurationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            // Général
            ['cle'=>'nom_app',          'valeur'=>'GesProjet',              'type'=>'text',    'groupe'=>'general',  'label'=>"Nom de l'application",       'description'=>"Nom affiché dans l'interface"],
            ['cle'=>'description_app',  'valeur'=>'Système de gestion de projets', 'type'=>'text', 'groupe'=>'general', 'label'=>'Description',             'description'=>'Description courte de l\'application'],
            ['cle'=>'logo_texte',       'valeur'=>'GP',                     'type'=>'text',    'groupe'=>'general',  'label'=>'Texte du logo',              'description'=>'Initiales affichées dans le logo (max 2 caractères)'],
            ['cle'=>'logo_image',       'valeur'=>null,                     'type'=>'image',   'groupe'=>'general',  'label'=>'Logo de l\'application',       'description'=>'Image affichée dans l\'application (2 Mo maximum).'],
            ['cle'=>'couleur_primaire', 'valeur'=>'#6366f1',                'type'=>'color',   'groupe'=>'general',  'label'=>'Couleur principale',         'description'=>'Couleur principale de l\'interface'],
            ['cle'=>'mode_maintenance', 'valeur'=>'0',                      'type'=>'boolean', 'groupe'=>'general',  'label'=>'Mode maintenance',           'description'=>'Activer pour bloquer l\'accès aux utilisateurs'],

            // Email
            ['cle'=>'email_expediteur', 'valeur'=>'no-reply@gesprojet.com', 'type'=>'email',   'groupe'=>'email',    'label'=>'Email expéditeur',           'description'=>'Adresse email utilisée pour envoyer les notifications'],
            ['cle'=>'nom_expediteur',   'valeur'=>'GesProjet',              'type'=>'text',    'groupe'=>'email',    'label'=>'Nom expéditeur',             'description'=>'Nom affiché comme expéditeur des emails'],
            ['cle'=>'email_admin',      'valeur'=>'admin@gesprojet.com',    'type'=>'email',   'groupe'=>'email',    'label'=>'Email administrateur',       'description'=>'Email de l\'administrateur pour les alertes système'],
            ['cle'=>'notif_email',      'valeur'=>'1',                      'type'=>'boolean', 'groupe'=>'email',    'label'=>'Notifications par email',    'description'=>'Activer l\'envoi d\'emails pour les événements projets'],

            // Projets
            ['cle'=>'max_projets_porteur',     'valeur'=>'0',  'type'=>'number',  'groupe'=>'projets', 'label'=>'Max projets par porteur',      'description'=>'Nombre maximum de projets actifs par porteur (0 = illimité)'],
            ['cle'=>'delai_approbation',       'valeur'=>'0', 'type'=>'number',  'groupe'=>'projets', 'label'=>'Délai max approbation (jours)', 'description'=>'Nombre de jours avant qu\'un projet soumis soit considéré en retard'],
            ['cle'=>'delai_validation',        'valeur'=>'0', 'type'=>'number',  'groupe'=>'projets', 'label'=>'Délai max validation (jours)',  'description'=>'Nombre de jours avant qu\'un projet approuvé soit considéré en retard'],
            ['cle'=>'budget_min',              'valeur'=>'0',  'type'=>'number',  'groupe'=>'projets', 'label'=>'Budget minimum (F CFA)',        'description'=>'Montant minimum pour soumettre un projet (0 = pas de minimum)'],
            ['cle'=>'budget_max',              'valeur'=>'0',  'type'=>'number',  'groupe'=>'projets', 'label'=>'Budget maximum (F CFA)',        'description'=>'Montant maximum accepté (0 = pas de maximum)'],
            ['cle'=>'docs_obligatoires',       'valeur'=>'0',  'type'=>'boolean', 'groupe'=>'projets', 'label'=>'Documents obligatoires',       'description'=>'Exiger au moins un document pour soumettre un projet'],

            // Sécurité
            ['cle'=>'session_duree',           'valeur'=>'0','type'=>'number',  'groupe'=>'securite','label'=>'Durée session (minutes)',       'description'=>'Durée avant déconnexion automatique'],
            ['cle'=>'tentatives_connexion',    'valeur'=>'3',  'type'=>'number',  'groupe'=>'securite','label'=>'Tentatives de connexion max',   'description'=>'Nombre max de tentatives avant blocage temporaire'],
        ];

        foreach ($configs as $config) {
            DB::table('configurations')->updateOrInsert(
                ['cle' => $config['cle']],
                array_merge($config, ['created_at'=>now(),'updated_at'=>now()])
            );
        }
    }
}
