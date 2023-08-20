<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ville
 * 
 * @property int $id
 * @property string|null $nom_ville
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $commune_quartier_id
 * 
 * @property CommuneQuartier $commune_quartier
 *
 * @package App\Models
 */
class Ville extends Model
{
	protected $table = 'ville';

	protected $casts = [
		'commune_quartier_id' => 'int'
	];

	protected $fillable = [
		'nom_ville',
		'commune_quartier_id'
	];

	public function commune_quartier()
	{
		return $this->belongsTo(CommuneQuartier::class);
	}
}
