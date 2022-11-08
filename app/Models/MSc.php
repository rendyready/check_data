<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MSc
 * 
 * @property int $id
 * @property float $m_sc_value
 * @property int $m_sc_created_by
 * @property Carbon $m_sc_created_at
 * @property int|null $m_sc_updated_by
 * @property Carbon|null $m_sc_updated_at
 * @property Carbon|null $m_sc_deleted_at
 *
 * @package App\Models
 */
class MSc extends Model
{
	protected $table = 'm_sc';
	public $timestamps = false;

	protected $casts = [
		'm_sc_value' => 'float',
		'm_sc_created_by' => 'int',
		'm_sc_updated_by' => 'int'
	];

	protected $dates = [
		'm_sc_created_at',
		'm_sc_updated_at',
		'm_sc_deleted_at'
	];

	protected $fillable = [
		'm_sc_value',
		'm_sc_created_by',
		'm_sc_created_at',
		'm_sc_updated_by',
		'm_sc_updated_at',
		'm_sc_deleted_at'
	];
}
