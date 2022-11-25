<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTarikanKasir
 * 
 * @property int $r_t_k_id
 * @property Carbon $r_t_k_tanggal
 * @property int $r_t_k_shift
 * @property int $r_t_k_m_w_id
 * @property string $r_t_k_m_w_nama
 * @property int $r_t_k_m_area_id
 * @property string $r_t_k_m_area_nama
 * @property int $r_t_k_kasir_id
 * @property string $r_t_k_kasir_nama
 * @property string $r_t_k_status_sync
 * @property int $r_t_k_created_by
 * @property int|null $r_t_k_updated_by
 * @property Carbon $r_t_k_created_at
 * @property Carbon|null $r_t_k_updated_at
 * @property Carbon|null $r_t_k_deleted_at
 *
 * @package App\Models
 */
class RekapTarikanKasir extends Model
{
	protected $table = 'rekap_tarikan_kasir';
	protected $primaryKey = 'r_t_k_id';
	public $timestamps = false;

	protected $casts = [
		'r_t_k_shift' => 'int',
		'r_t_k_m_w_id' => 'int',
		'r_t_k_m_area_id' => 'int',
		'r_t_k_kasir_id' => 'int',
		'r_t_k_created_by' => 'int',
		'r_t_k_updated_by' => 'int'
	];

	protected $dates = [
		'r_t_k_tanggal',
		'r_t_k_created_at',
		'r_t_k_updated_at',
		'r_t_k_deleted_at'
	];

	protected $fillable = [
		'r_t_k_tanggal',
		'r_t_k_shift',
		'r_t_k_m_w_id',
		'r_t_k_m_w_nama',
		'r_t_k_m_area_id',
		'r_t_k_m_area_nama',
		'r_t_k_kasir_id',
		'r_t_k_kasir_nama',
		'r_t_k_status_sync',
		'r_t_k_created_by',
		'r_t_k_updated_by',
		'r_t_k_created_at',
		'r_t_k_updated_at',
		'r_t_k_deleted_at'
	];
}
