<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $role
 * @property int|null $filiere_id
 * @property bool $must_change_password
 * 
 * @property Filiere|null $filiere
 * @property Collection|Pv[] $pvs
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'filiere_id' => 'int',
		'must_change_password' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'must_change_password'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'role',
		'filiere_id',
		'must_change_password'
	];

	public function filiere()
	{
		return $this->belongsTo(Filiere::class);
	}

	public function pvs()
	{
		return $this->hasMany(Pv::class, 'depose_par');
	}
}
