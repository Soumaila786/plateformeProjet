<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planification extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPlanification';

    protected $fillable = [
        'activitePlanification',
        'indicateur',
        'uniteIndicateur',
        'resultatsAttendues',
        'coutEstimatif',
        'periode',
        'projet_id',
    ];

    protected $casts = [
        'coutEstimatif' => 'decimal:2',
    ];

    // ── Relations ──
    public function projet(){
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    // ── Accesseurs corrigés (projet singulier) ──
    public function getPorteurAttribute()
    {
        return optional($this->projet)->porteur;  // ← était $this->projets (pluriel)
    }

    public function getPorteurIdAttribute()
    {
        return optional($this->projet)->user_id;  // ← était $this->projets (pluriel)
    }
}
