<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MResep
 * 
 * @property int $id
 * @property int $m_resep_id
 * @property int $m_resep_m_produk_id
 * @property string $m_resep_keterangan
 * @property string $m_resep_status
 * @property int $m_resep_created_by
 * @property int|null $m_resep_updated_by
 * @property int|null $m_resep_deleted_by
 * @property Carbon $m_resep_created_at
 * @property Carbon|null $m_resep_updated_at
 * @property Carbon|null $m_resep_deleted_at
 *
 * @package App\Models
 */
class MResep extends Model
{
	protected $table = 'm_resep';
	public $timestamps = false;

	protected $casts = [
		'm_resep_id' => 'int',
		'm_resep_m_produk_id' => 'int',
		'm_resep_created_by' => 'int',
		'm_resep_updated_by' => 'int',
		'm_resep_deleted_by' => 'int'
	];

	protected $dates = [
		'm_resep_created_at',
		'm_resep_updated_at',
		'm_resep_deleted_at'
	];

	protected $fillable = [
		'm_resep_id',
		'm_resep_m_produk_id',
		'm_resep_keterangan',
		'm_resep_status',
		'm_resep_created_by',
		'm_resep_updated_by',
		'm_resep_deleted_by',
		'm_resep_created_at',
		'm_resep_updated_at',
		'm_resep_deleted_at'
	];
}
