<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Configuration;

class AppServiceProvider extends ServiceProvider {
    public function register() {
        //
    }

    public function boot() {
        
        // Fix: clé trop longue avec MySQL < 5.7.7
        Schema::defaultStringLength(191);

        // Charger la config système et la partager avec TOUTES les vues
        try {
            if (\Schema::hasTable('configurations')) {
                $sysConfig = Configuration::all()->pluck('valeur', 'cle');
                View::share('sysConfig', $sysConfig);
            } else {
                View::share('sysConfig', collect());
            }
        } catch (\Exception $e) {
            View::share('sysConfig', collect());
        }
    }
}
