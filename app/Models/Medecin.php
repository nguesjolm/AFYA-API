<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Medecin
 * 
 * @property int $id
 * @property string|null $nom
 * @property string|null $telephone
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $email
 * @property string|null $code_parrainage
 * @property string|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Medecin extends Model
{
	protected $table = 'medecin';

	protected $fillable = [
		'nom',
		'telephone',
		'ville',
		'commune_quartier',
		'email',
		'code_parrainage',
		'id_users'
	];
}
