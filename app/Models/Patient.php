<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * 
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $date_naissance
 * @property string|null $genre
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $password
 * @property string|null $cni
 * @property string|null $profession
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $parrainage
 * @property int|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Facture[] $factures
 * @property Collection|Ordonnance[] $ordonnances
 *
 * @package App\Models
 */
class Patient extends Model
{
	protected $table = 'patients';

	protected $casts = [
		'id_users' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'date_naissance',
		'genre',
		'telephone',
		'email',
		'password',
		'cni',
		'profession',
		'ville',
		'commune_quartier',
		'parrainage',
		'id_users'
	];

	public function factures()
	{
		return $this->hasMany(Facture::class, 'patients_id');
	}

	public function ordonnances()
	{
		return $this->hasMany(Ordonnance::class, 'patients_id');
	}
}
