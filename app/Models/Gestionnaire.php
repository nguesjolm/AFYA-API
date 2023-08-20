<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gestionnaire
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $date_naissance
 * @property string $telephone
 * @property string $email
 * @property string $cni
 * @property string $domicile
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $actif
 * @property string|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Superviseur[] $superviseurs
 *
 * @package App\Models
 */
class Gestionnaire extends Model
{
	protected $table = 'gestionnaires';

	protected $fillable = [
		'nom',
		'prenom',
		'date_naissance',
		'telephone',
		'email',
		'cni',
		'domicile',
		'ville',
		'commune_quartier',
		'actif',
		'id_users'
	];

	public function superviseurs()
	{
		return $this->hasMany(Superviseur::class, 'gestionnaires_id');
	}
}
