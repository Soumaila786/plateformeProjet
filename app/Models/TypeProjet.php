<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeProjet extends Model
{
    protected $table = 'types_projets';

    protected $fillable = [
        'nom',
        'description',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function projets()
    {
        return $this->hasMany(Projet::class, 'type_projet_id');
    }
}
