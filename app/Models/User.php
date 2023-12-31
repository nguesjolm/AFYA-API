<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $email
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Model
{
	use HasApiTokens, HasFactory;
	protected $table = 'users';

	protected $hidden = [
		'remember_token'
	];

	protected $fillable = [
		'email',
		'phone',
		'remember_token'
	];
}
