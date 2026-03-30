<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller {

    public function index() {

        $configs = Configuration::grouped();
        
        $groupes = [
            'general'  => ['label' => 'Général',    'icon' => 'fa-cog'],
            'email'    => ['label' => 'Email',       'icon' => 'fa-envelope'],
            'projets'  => ['label' => 'Projets',     'icon' => 'fa-folder'],
            'securite' => ['label' => 'Sécurité',    'icon' => 'fa-shield-alt'],
        ];

        return view('admin.configuration.index', compact('configs', 'groupes'));
    }

    public function update(Request $request) {
        // Valider les champs numériques et email
        $rules = [];
        $configs = Configuration::all();

        foreach ($configs as $config) {
            if ($config->type === 'email') {
                $rules[$config->cle] = 'nullable|email';
            } elseif ($config->type === 'number') {
                $rules[$config->cle] = 'nullable|numeric|min:0';
            } elseif ($config->type === 'color') {
                $rules[$config->cle] = 'nullable|regex:/^#[0-9A-Fa-f]{6}$/';
            }
        }

        $request->validate($rules);

        // Sauvegarder chaque config
        foreach ($configs as $config) {
            if ($config->type === 'boolean') {
                // Checkbox : si pas dans le request = 0
                $valeur = $request->has($config->cle) ? '1' : '0';
            } else {
                $valeur = $request->input($config->cle, $config->valeur);
            }
            $config->update(['valeur' => $valeur]);
        }

        return back()->with('success', 'Configuration mise à jour avec succès.');
    }

    // Reset une config à sa valeur par défaut
    public function reset($cle) {
        $defaults = [
            'nom_app'               => 'GesProjet',
            'couleur_primaire'      => '#6366f1',
            'mode_maintenance'      => '0',
            'max_projets_porteur'   => '0',
            'delai_approbation'     => '0',
            'delai_validation'      => '0',
            'notif_email'           => '1',
            'docs_obligatoires'     => '0',
            'session_duree'         => '0',
            'tentatives_connexion'  => '3',
            'budget_min'            => '0',
            'budget_max'            => '0',
        ];

        if (isset($defaults[$cle])) {
            Configuration::where('cle', $cle)->update(['valeur' => $defaults[$cle]]);
        }

        return back()->with('success', 'Paramètre réinitialisé.');
    }
}
