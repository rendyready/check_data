<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rph
 * 
 * @property int $id
 * @property string $rph_code
 * @property Carbon $rph_tgl
 * @property int $rph_m_w_id
 * @property string $rph_m_w_nama
 * @property int $rph_created_by
 * @property int|null $rph_updated_by
 * @property int|null $rph_deleted_by
 * @property Carbon $rph_created_at
 * @property Carbon|null $rph_updated_at
 * @property Carbon|null $rph_deleted_at
 *
 * @package App\Models
 */
class Rph extends Model
{
	protected $table = 'rph';
	public $timestamps = false;

	protected $casts = [
		'rph_tgl' => 'datetime',
		'rph_m_w_id' => 'int',
		'rph_created_by' => 'int',
		'rph_updated_by' => 'int',
		'rph_deleted_by' => 'int',
		'rph_created_at' => 'datetime',
		'rph_updated_at' => 'datetime',
		'rph_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rph_code',
		'rph_tgl',
		'rph_m_w_id',
		'rph_m_w_nama',
		'rph_created_by',
		'rph_updated_by',
		'rph_deleted_by',
		'rph_created_at',
		'rph_updated_at',
		'rph_deleted_at'
	];
}
