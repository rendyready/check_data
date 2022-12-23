<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapUangTip
 * 
 * @property int $r_u_t_id
 * @property int|null $r_u_t_sync_id
 * @property int $r_u_t_rekap_modal_id
 * @property Carbon $r_u_t_tanggal
 * @property float $r_u_t_nominal
 * @property int $r_u_t_m_w_id
 * @property int $r_u_t_m_area_id
 * @property string $r_u_t_keterangan
 * @property string $r_u_t_status_sync
 * @property int $r_u_t_created_by
 * @property int|null $r_u_t_updated_by
 * @property int|null $r_u_t_deleted_by
 * @property Carbon $r_u_t_created_at
 * @property Carbon|null $r_u_t_updated_at
 * @property Carbon|null $r_u_t_deleted_at
 *
 * @package App\Models
 */
class RekapUangTip extends Model
{
	protected $table = 'rekap_uang_tips';
	protected $primaryKey = 'r_u_t_id';
	public $timestamps = false;

	protected $casts = [
		'r_u_t_sync_id' => 'int',
		'r_u_t_rekap_modal_id' => 'int',
		'r_u_t_nominal' => 'float',
		'r_u_t_m_w_id' => 'int',
		'r_u_t_m_area_id' => 'int',
		'r_u_t_created_by' => 'int',
		'r_u_t_updated_by' => 'int',
		'r_u_t_deleted_by' => 'int'
	];

	protected $dates = [
		'r_u_t_tanggal',
		'r_u_t_created_at',
		'r_u_t_updated_at',
		'r_u_t_deleted_at'
	];

	protected $fillable = [
		'r_u_t_sync_id',
		'r_u_t_rekap_modal_id',
		'r_u_t_tanggal',
		'r_u_t_nominal',
		'r_u_t_m_w_id',
		'r_u_t_m_area_id',
		'r_u_t_keterangan',
		'r_u_t_status_sync',
		'r_u_t_created_by',
		'r_u_t_updated_by',
		'r_u_t_deleted_by',
		'r_u_t_created_at',
		'r_u_t_updated_at',
		'r_u_t_deleted_at'
	];
}
