<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planification extends Model {

    use HasFactory;

    protected $primaryKey = 'idPlanification';

    protected $fillable = [
        'activitePlanification',
        'reference',
        'indicateur',
        'uniteIndicateur',
        'resultatsAttendues',
        'coutEstimatif',
        'periode',
        'projet_id'
    ];

    protected $casts = [
        'coutEstimatif' => 'decimal:2'
    ];


    public function projet() {
        return $this->belongsTo(Projet::class);
    }


    public function getPorteurAttribute() {
        return $this->projets->porteur;
    }

    public function getPorteurIdAttribute() {
        return $this->projets->porteur_id;
    }
}
