<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;

    protected $table = 'activites';

    protected $fillable = [
        'activite',
        'descriptionActivite',
        'statutActivite',
        'indicateur',
        'uniteIndicateur',
        'resultatsAttendues',
        'coutEstimatif',
        'periode',
        'projet_id',
        'planificateur_id',
    ];

    protected $casts = [
        'indicateur'    => 'integer',
        'coutEstimatif' => 'decimal:2',
    ];

    // ── Relations ──

    public function projet() {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function planificateur() {
        return $this->belongsTo(User::class, 'planificateur_id');
    }

    // ── Helpers ──

    public function isEnCours(): bool {
        return $this->statutActivite === 'en_cours';
    }

    public function isTerminee(): bool {
        return $this->statutActivite === 'termine';
    }
}
