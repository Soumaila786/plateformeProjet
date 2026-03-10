<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentProjet extends Model
{
    protected $table = 'document_projets';

    protected $fillable = [
        'nomFichier',
        'typeDocument',
        'cheminFichier',
        'dateUpload',
        'projet_id',
        'uploader_id',
    ];

    protected $dates = ['dateUpload'];

    // ── Relations ──

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
