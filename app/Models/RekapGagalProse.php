<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapGagalProse
 * 
 * @property int $r_g_p_id
 * @property Carbon $r_g_p_tanggal
 * @property int $r_g_p_shift
 * @property time without time zone $r_g_p_jam
 * @property string $r_g_p_m_menu_code
 * @property int $r_g_p_m_menu_id
 * @property string $r_g_p_m_menu_nama
 * @property int $r_g_p_m_menu_jenis_id
 * @property string $r_g_p_m_menu_jenis_nama
 * @property string $r_g_p_m_menu_urut
 * @property float $r_g_p_m_menu_harga_nominal
 * @property int $r_g_p_qty
 * @property float $r_g_p_nominal
 * @property string $r_g_p_keterangan
 * @property int $r_g_p_m_w_id
 * @property string $r_g_p_m_w_nama
 * @property int $r_g_p_m_area_id
 * @property string $r_g_p_m_area_nama
 * @property int $r_g_p_kasir_id
 * @property string $r_g_p_kasir_nama
 * @property string $r_g_p_status_sync
 * @property int $r_g_p_created_by
 * @property int|null $r_g_p_updated_by
 * @property Carbon $r_g_p_created_at
 * @property Carbon|null $r_g_p_updated_at
 * @property Carbon|null $r_g_p_deleted_at
 *
 * @package App\Models
 */
class RekapGagalProse extends Model
{
	protected $table = 'rekap_gagal_proses';
	protected $primaryKey = 'r_g_p_id';
	public $timestamps = false;

	protected $casts = [
		'r_g_p_shift' => 'int',
		'r_g_p_jam' => 'time without time zone',
		'r_g_p_m_menu_id' => 'int',
		'r_g_p_m_menu_jenis_id' => 'int',
		'r_g_p_m_menu_harga_nominal' => 'float',
		'r_g_p_qty' => 'int',
		'r_g_p_nominal' => 'float',
		'r_g_p_m_w_id' => 'int',
		'r_g_p_m_area_id' => 'int',
		'r_g_p_kasir_id' => 'int',
		'r_g_p_created_by' => 'int',
		'r_g_p_updated_by' => 'int'
	];

	protected $dates = [
		'r_g_p_tanggal',
		'r_g_p_created_at',
		'r_g_p_updated_at',
		'r_g_p_deleted_at'
	];

	protected $fillable = [
		'r_g_p_tanggal',
		'r_g_p_shift',
		'r_g_p_jam',
		'r_g_p_m_menu_code',
		'r_g_p_m_menu_id',
		'r_g_p_m_menu_nama',
		'r_g_p_m_menu_jenis_id',
		'r_g_p_m_menu_jenis_nama',
		'r_g_p_m_menu_urut',
		'r_g_p_m_menu_harga_nominal',
		'r_g_p_qty',
		'r_g_p_nominal',
		'r_g_p_keterangan',
		'r_g_p_m_w_id',
		'r_g_p_m_w_nama',
		'r_g_p_m_area_id',
		'r_g_p_m_area_nama',
		'r_g_p_kasir_id',
		'r_g_p_kasir_nama',
		'r_g_p_status_sync',
		'r_g_p_created_by',
		'r_g_p_updated_by',
		'r_g_p_created_at',
		'r_g_p_updated_at',
		'r_g_p_deleted_at'
	];
}
