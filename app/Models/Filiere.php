<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Filiere
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Pv[] $pvs
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Filiere extends Model
{
	protected $table = 'filieres';

	public function pvs()
	{
		return $this->hasMany(Pv::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
