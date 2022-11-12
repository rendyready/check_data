<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPreVoid
 * 
 * @property int $r_p_v_id
 * @property int $r_p_v_r_t_id
 * @property Carbon $r_p_v_tanggal
 * @property int $r_p_v_shift
 * @property time without time zone $r_p_v_jam
 * @property string $r_p_v_nota_code
 * @property int $r_p_v_m_menu_id
 * @property string $r_p_v_m_menu_nama
 * @property string $r_p_v_m_menu_cr
 * @property string $r_p_v_m_menu_urut
 * @property int $r_p_v_m_menu_jenis_id
 * @property string $r_p_v_m_menu_jenis_nama
 * @property float $r_p_v_m_menu_harga_nominal
 * @property int $r_p_v_qty
 * @property float $r_p_v_nominal
 * @property string $r_p_v_keterangan
 * @property int $r_p_v_m_w_id
 * @property string $r_p_v_m_w_nama
 * @property int $r_p_v_m_area_id
 * @property string $r_p_v_m_area_nama
 * @property int $r_p_v_kasir_id
 * @property string $r_p_v_kasir_nama
 * @property string $r_p_v_status_sync
 * @property int $r_p_v_created_by
 * @property int|null $r_p_v_updated_by
 * @property Carbon $r_p_v_created_at
 * @property Carbon|null $r_p_v_updated_at
 * @property Carbon|null $r_p_v_deleted_at
 *
 * @package App\Models
 */
class RekapPreVoid extends Model
{
	protected $table = 'rekap_pre_void';
	protected $primaryKey = 'r_p_v_id';
	public $timestamps = false;

	protected $casts = [
		'r_p_v_r_t_id' => 'int',
		'r_p_v_shift' => 'int',
		'r_p_v_jam' => 'time without time zone',
		'r_p_v_m_menu_id' => 'int',
		'r_p_v_m_menu_jenis_id' => 'int',
		'r_p_v_m_menu_harga_nominal' => 'float',
		'r_p_v_qty' => 'int',
		'r_p_v_nominal' => 'float',
		'r_p_v_m_w_id' => 'int',
		'r_p_v_m_area_id' => 'int',
		'r_p_v_kasir_id' => 'int',
		'r_p_v_created_by' => 'int',
		'r_p_v_updated_by' => 'int'
	];

	protected $dates = [
		'r_p_v_tanggal',
		'r_p_v_created_at',
		'r_p_v_updated_at',
		'r_p_v_deleted_at'
	];

	protected $fillable = [
		'r_p_v_r_t_id',
		'r_p_v_tanggal',
		'r_p_v_shift',
		'r_p_v_jam',
		'r_p_v_nota_code',
		'r_p_v_m_menu_id',
		'r_p_v_m_menu_nama',
		'r_p_v_m_menu_cr',
		'r_p_v_m_menu_urut',
		'r_p_v_m_menu_jenis_id',
		'r_p_v_m_menu_jenis_nama',
		'r_p_v_m_menu_harga_nominal',
		'r_p_v_qty',
		'r_p_v_nominal',
		'r_p_v_keterangan',
		'r_p_v_m_w_id',
		'r_p_v_m_w_nama',
		'r_p_v_m_area_id',
		'r_p_v_m_area_nama',
		'r_p_v_kasir_id',
		'r_p_v_kasir_nama',
		'r_p_v_status_sync',
		'r_p_v_created_by',
		'r_p_v_updated_by',
		'r_p_v_created_at',
		'r_p_v_updated_at',
		'r_p_v_deleted_at'
	];
}
