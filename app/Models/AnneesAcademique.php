<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnneesAcademique
 * 
 * @property int $id
 * @property string $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Pv[] $pvs
 *
 * @package App\Models
 */
class AnneesAcademique extends Model
{
	protected $table = 'annees_academiques';

	protected $fillable = [
		'libelle'
	];

	public function pvs()
	{
		return $this->hasMany(Pv::class, 'annee_academique_id');
	}
}
