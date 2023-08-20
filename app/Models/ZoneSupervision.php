<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ZoneSupervision
 * 
 * @property int $id
 * @property int $superviseurs_id
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Superviseur $superviseur
 * @property Collection|Livreur[] $livreurs
 * @property Collection|Pharmacy[] $pharmacies
 *
 * @package App\Models
 */
class ZoneSupervision extends Model
{
	protected $table = 'zone_supervisions';

	protected $casts = [
		'superviseurs_id' => 'int'
	];

	protected $fillable = [
		'superviseurs_id',
		'ville',
		'commune_quartier',
		'code'
	];

	public function superviseur()
	{
		return $this->belongsTo(Superviseur::class, 'superviseurs_id');
	}

	public function livreurs()
	{
		return $this->hasMany(Livreur::class, 'zone_supervisions_id');
	}

	public function pharmacies()
	{
		return $this->hasMany(Pharmacy::class, 'zone_supervisions_id');
	}
}
