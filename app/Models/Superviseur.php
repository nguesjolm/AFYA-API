<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Superviseur
 * 
 * @property int $id
 * @property int $gestionnaires_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Gestionnaire $gestionnaire
 * @property Collection|ZoneSupervision[] $zone_supervisions
 *
 * @package App\Models
 */
class Superviseur extends Model
{
	protected $table = 'superviseurs';

	protected $casts = [
		'gestionnaires_id' => 'int'
	];

	protected $fillable = [
		'gestionnaires_id'
	];

	public function gestionnaire()
	{
		return $this->belongsTo(Gestionnaire::class, 'gestionnaires_id');
	}

	public function zone_supervisions()
	{
		return $this->hasMany(ZoneSupervision::class, 'superviseurs_id');
	}
}
