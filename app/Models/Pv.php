<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pv extends Model
{
    protected $table = 'pvs';

    protected $casts = [
        'depose_par' => 'int',
    ];

    protected $fillable = [
        'annee',
        'filiere_code',
        'fichier_path',
        'nom_original',
        'depose_par',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'depose_par');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_code', 'code');
    }
}