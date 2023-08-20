<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Livreur
 * 
 * @property int $id
 * @property int $zone_supervisions_id
 * @property string $nom
 * @property string $prenom
 * @property string $date_naissance
 * @property string $telephone
 * @property string $cni
 * @property string $telephone_parents
 * @property string $email
 * @property string|null $nom_parent
 * @property string|null $actif
 * @property string|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ZoneSupervision $zone_supervision
 * @property Collection|Ordonnance[] $ordonnances
 *
 * @package App\Models
 */
class Livreur extends Model
{
	protected $table = 'livreurs';

	protected $casts = [
		'zone_supervisions_id' => 'int'
	];

	protected $fillable = [
		'zone_supervisions_id',
		'nom',
		'prenom',
		'date_naissance',
		'telephone',
		'cni',
		'telephone_parents',
		'email',
		'nom_parent',
		'actif',
		'id_users'
	];

	public function zone_supervision()
	{
		return $this->belongsTo(ZoneSupervision::class, 'zone_supervisions_id');
	}

	public function ordonnances()
	{
		return $this->hasMany(Ordonnance::class, 'livreurs_id');
	}
}
