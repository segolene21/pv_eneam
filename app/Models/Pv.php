<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pv
 * 
 * @property int $id
 * @property int $annee_academique_id
 * @property int $filiere_id
 * @property string $niveau
 * @property string $semestre
 * @property string $session
 * @property string $fichier_path
 * @property int $depose_par
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property AnneesAcademique $annees_academique
 * @property User $user
 * @property Filiere $filiere
 *
 * @package App\Models
 */
class Pv extends Model
{
	protected $table = 'pvs';

	protected $casts = [
		'annee_academique_id' => 'int',
		'filiere_id' => 'int',
		'depose_par' => 'int'
	];

	protected $fillable = [
		'annee_academique_id',
		'filiere_id',
		'niveau',
		'semestre',
		'session',
		'fichier_path',
		'depose_par'
	];

	public function annees_academique()
	{
		return $this->belongsTo(AnneesAcademique::class, 'annee_academique_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'depose_par');
	}

	public function filiere()
	{
		return $this->belongsTo(Filiere::class);
	}
}
