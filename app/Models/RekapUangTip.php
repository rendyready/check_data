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
 * @property Carbon $r_u_t_tanggal
 * @property int $r_u_t_shift
 * @property time without time zone $r_u_t_jam
 * @property int $r_u_t_m_karyawan_id
 * @property string $r_u_t_m_karyawan_nama
 * @property float $r_u_t_debit
 * @property float $r_u_t_kredit
 * @property int $r_u_t_m_w_id
 * @property string $r_u_t_m_w_nama
 * @property int $r_u_t_m_area_id
 * @property string $r_u_t_m_area_nama
 * @property int $r_u_t_kasir_id
 * @property string $r_u_t_kasir_nama
 * @property string $r_u_t_keterangan
 * @property string $r_u_t_status_sync
 * @property int $r_u_t_created_by
 * @property int|null $r_u_t_updated_by
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
		'r_u_t_shift' => 'int',
		'r_u_t_jam' => 'time without time zone',
		'r_u_t_m_karyawan_id' => 'int',
		'r_u_t_debit' => 'float',
		'r_u_t_kredit' => 'float',
		'r_u_t_m_w_id' => 'int',
		'r_u_t_m_area_id' => 'int',
		'r_u_t_kasir_id' => 'int',
		'r_u_t_created_by' => 'int',
		'r_u_t_updated_by' => 'int'
	];

	protected $dates = [
		'r_u_t_tanggal',
		'r_u_t_created_at',
		'r_u_t_updated_at',
		'r_u_t_deleted_at'
	];

	protected $fillable = [
		'r_u_t_tanggal',
		'r_u_t_shift',
		'r_u_t_jam',
		'r_u_t_m_karyawan_id',
		'r_u_t_m_karyawan_nama',
		'r_u_t_debit',
		'r_u_t_kredit',
		'r_u_t_m_w_id',
		'r_u_t_m_w_nama',
		'r_u_t_m_area_id',
		'r_u_t_m_area_nama',
		'r_u_t_kasir_id',
		'r_u_t_kasir_nama',
		'r_u_t_keterangan',
		'r_u_t_status_sync',
		'r_u_t_created_by',
		'r_u_t_updated_by',
		'r_u_t_created_at',
		'r_u_t_updated_at',
		'r_u_t_deleted_at'
	];
}
