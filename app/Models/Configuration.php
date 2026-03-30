<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model {

    protected $table = 'configurations';

    protected $fillable = [
        'cle',
        'valeur',
        'type',
        'groupe',
        'label',
        'description',
    ];

    // Récupérer une valeur par clé
    public static function get($cle, $defaut = null) {
        
        $config = static::where('cle', $cle)->first();
        return $config ? $config->valeur : $defaut;
    }

    // Définir une valeur
    public static function set($cle, $valeur) {

        static::where('cle', $cle)->update(['valeur' => $valeur]);
    }

    // Récupérer toutes les configs groupées
    public static function grouped() {

        return static::all()->groupBy('groupe');
    }
}
