<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminnistrateur extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'datePriseFonction'
    ];

    protected $casts = [
        'datePriseFonction' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
