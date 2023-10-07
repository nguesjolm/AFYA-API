<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\HasFactory;
use App\Models\Notifiable;


/**
 * Class Ordonnance
 * 
 * @property int $id
 * @property int $patients_id
 * @property int|null $livreurs_id
 * @property string|null $photo_1
 * @property string|null $photo_2
 * @property string|null $photo_3
 * @property string|null $writing
 * @property string|null $prescription_audio
 * @property string|null $prescription_video
 * @property string|null $prescription_texte
 * @property string|null $date_soumission
 * @property string|null $longitude
 * @property string|null $latitude
 * @property string|null $delivery_state
 * @property string|null $payement
 * @property string|null $numero_ordonnance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Livreur|null $livreur
 * @property Patient $patient
 * @property Collection|Facture[] $factures
 * @property Collection|OrdonnancesHasPharmacy[] $ordonnances_has_pharmacies
 *
 * @package App\Models
 */
class Ordonnance extends Model
{
	
	protected $table = 'ordonnances';

	protected $casts = [
		'patients_id' => 'int',
		'livreurs_id' => 'int'
	];

	protected $fillable = [
		'patients_id',
		'livreurs_id',
		'photo_1',
		'photo_2',
		'photo_3',
		'writing',
		'prescription_audio',
		'prescription_video',
		'prescription_texte',
		'date_soumission',
		'longitude',
		'latitude',
		'delivery_state',
		'payement',
		'numero_ordonnance'
	];

	public function livreur()
	{
		return $this->belongsTo(Livreur::class, 'livreurs_id');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'patients_id');
	}

	public function factures()
	{
		return $this->hasMany(Facture::class, 'ordonnances_id');
	}

	public function ordonnances_has_pharmacies()
	{
		return $this->hasMany(OrdonnancesHasPharmacy::class, 'ordonnances_id');
	}
}
