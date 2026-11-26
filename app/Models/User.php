<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property int|null $filiere_id
 * @property bool $must_change_password
 */
class User extends Authenticatable
{
	use HasFactory, Notifiable;

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

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'filiere_id' => 'int',
		'must_change_password' => 'bool'
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