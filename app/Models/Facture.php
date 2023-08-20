<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Facture
 * 
 * @property int $id
 * @property int $patients_id
 * @property int $pharmacies_id
 * @property int $ordonnances_id
 * @property string|null $numero_facture
 * @property int $prix
 * @property string $description
 * @property int $montant
 * @property string $date_facture
 * @property string|null $payement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ordonnance $ordonnance
 * @property Patient $patient
 * @property Pharmacy $pharmacy
 *
 * @package App\Models
 */
class Facture extends Model
{
	protected $table = 'factures';

	protected $casts = [
		'patients_id' => 'int',
		'pharmacies_id' => 'int',
		'ordonnances_id' => 'int',
		'prix' => 'int',
		'montant' => 'int'
	];

	protected $fillable = [
		'patients_id',
		'pharmacies_id',
		'ordonnances_id',
		'numero_facture',
		'prix',
		'description',
		'montant',
		'date_facture',
		'payement'
	];

	public function ordonnance()
	{
		return $this->belongsTo(Ordonnance::class, 'ordonnances_id');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'patients_id');
	}

	public function pharmacy()
	{
		return $this->belongsTo(Pharmacy::class, 'pharmacies_id');
	}
}
