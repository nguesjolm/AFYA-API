<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdonnancesHasPharmacy
 * 
 * @property int $ordonnances_id
 * @property int $pharmacies_id
 * 
 * @property Ordonnance $ordonnance
 * @property Pharmacy $pharmacy
 *
 * @package App\Models
 */
class OrdonnancesHasPharmacy extends Model
{
	protected $table = 'ordonnances_has_pharmacies';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ordonnances_id' => 'int',
		'pharmacies_id' => 'int'
	];

	public function ordonnance()
	{
		return $this->belongsTo(Ordonnance::class, 'ordonnances_id');
	}

	public function pharmacy()
	{
		return $this->belongsTo(Pharmacy::class, 'pharmacies_id');
	}
}
