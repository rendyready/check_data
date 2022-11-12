<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MRekapVoid
 * 
 * @property int $m_r_v_id
 * @property int $m_r_v_r_t_id
 * @property Carbon $m_r_v_tanggal
 * @property int $m_r_v_shift
 * @property time without time zone $m_r_v_jam
 * @property string $m_r_v_nota_code
 * @property int $m_r_v_m_menu_id
 * @property string $m_r_v_m_menu_nama
 * @property string $m_r_v_m_menu_cr
 * @property string $m_r_v_m_menu_urut
 * @property int $m_r_v_m_menu_jenis_id
 * @property string $m_r_v_m_menu_jenis_nama
 * @property float $m_r_v_m_menu_harga_nominal
 * @property int $m_r_v_qty
 * @property float $m_r_v_nominal
 * @property string|null $m_r_v_tax_status
 * @property string|null $m_r_v_sc_status
 * @property string $m_r_v_keterangan
 * @property int $m_r_v_m_w_id
 * @property string $m_r_v_m_w_nama
 * @property int $m_r_v_m_area_id
 * @property string $m_r_v_m_area_nama
 * @property int $m_r_v_kasir_id
 * @property string $m_r_v_kasir_nama
 * @property string $m_r_v_status_sync
 * @property int $m_r_v_created_by
 * @property int|null $m_r_v_updated_by
 * @property Carbon $m_r_v_created_at
 * @property Carbon|null $m_r_v_updated_at
 * @property Carbon|null $m_r_v_deleted_at
 *
 * @package App\Models
 */
class MRekapVoid extends Model
{
	protected $table = 'm_rekap_void';
	protected $primaryKey = 'm_r_v_id';
	public $timestamps = false;

	protected $casts = [
		'm_r_v_r_t_id' => 'int',
		'm_r_v_shift' => 'int',
		'm_r_v_jam' => 'time without time zone',
		'm_r_v_m_menu_id' => 'int',
		'm_r_v_m_menu_jenis_id' => 'int',
		'm_r_v_m_menu_harga_nominal' => 'float',
		'm_r_v_qty' => 'int',
		'm_r_v_nominal' => 'float',
		'm_r_v_m_w_id' => 'int',
		'm_r_v_m_area_id' => 'int',
		'm_r_v_kasir_id' => 'int',
		'm_r_v_created_by' => 'int',
		'm_r_v_updated_by' => 'int'
	];

	protected $dates = [
		'm_r_v_tanggal',
		'm_r_v_created_at',
		'm_r_v_updated_at',
		'm_r_v_deleted_at'
	];

	protected $fillable = [
		'm_r_v_r_t_id',
		'm_r_v_tanggal',
		'm_r_v_shift',
		'm_r_v_jam',
		'm_r_v_nota_code',
		'm_r_v_m_menu_id',
		'm_r_v_m_menu_nama',
		'm_r_v_m_menu_cr',
		'm_r_v_m_menu_urut',
		'm_r_v_m_menu_jenis_id',
		'm_r_v_m_menu_jenis_nama',
		'm_r_v_m_menu_harga_nominal',
		'm_r_v_qty',
		'm_r_v_nominal',
		'm_r_v_tax_status',
		'm_r_v_sc_status',
		'm_r_v_keterangan',
		'm_r_v_m_w_id',
		'm_r_v_m_w_nama',
		'm_r_v_m_area_id',
		'm_r_v_m_area_nama',
		'm_r_v_kasir_id',
		'm_r_v_kasir_nama',
		'm_r_v_status_sync',
		'm_r_v_created_by',
		'm_r_v_updated_by',
		'm_r_v_created_at',
		'm_r_v_updated_at',
		'm_r_v_deleted_at'
	];
}
