<?php

// app/Models/Planificateur.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Planificateur extends Model {

    protected $table = 'planificateurs';
    
    protected $fillable = [
        'user_id',
        'service'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
