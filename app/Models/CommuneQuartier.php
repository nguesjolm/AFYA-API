<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommuneQuartier
 * 
 * @property int $id
 * @property string|null $nom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Ville[] $villes
 *
 * @package App\Models
 */
class CommuneQuartier extends Model
{
	protected $table = 'commune_quartier';

	protected $fillable = [
		'nom'
	];

	public function villes()
	{
		return $this->hasMany(Ville::class);
	}
}
