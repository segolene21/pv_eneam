<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nom
 * @property string $code
 */
class Filiere extends Model
{
    protected $table = 'filieres';

    protected $fillable = [
        'nom',
        'code',
    ];

    public function pvs()
    {
        return $this->hasMany(Pv::class, 'filiere_code', 'code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'filiere_code', 'code');
    }
}