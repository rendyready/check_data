<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapGaransi
 * 
 * @property int $r_g_id
 * @property int $r_g_r_t_id
 * @property Carbon $r_g_tanggal
 * @property int $r_g_shift
 * @property time without time zone $r_g_jam
 * @property string $r_g_nota_code
 * @property int $r_g_m_produk_id
 * @property string $r_g_m_produk_nama
 * @property string $r_g_m_menu_cr
 * @property string $r_g_m_menu_urut
 * @property int $r_g_m_jenis_produk_id
 * @property string $r_g_m_jenis_produk_nama
 * @property float $r_g_m_menu_harga_nominal
 * @property int $r_g_qty
 * @property float $r_g_nominal
 * @property string $r_g_keterangan
 * @property string $r_g_action
 * @property int $r_g_m_w_id
 * @property string $r_g_m_w_nama
 * @property int $r_g_m_area_id
 * @property string $r_g_m_area_nama
 * @property int $r_g_kasir_id
 * @property string $r_g_kasir_nama
 * @property string $r_g_status_sync
 * @property int $r_g_created_by
 * @property int|null $r_g_updated_by
 * @property Carbon $r_g_created_at
 * @property Carbon|null $r_g_updated_at
 * @property Carbon|null $r_g_deleted_at
 *
 * @package App\Models
 */
class RekapGaransi extends Model
{
	protected $table = 'rekap_garansi';
	protected $primaryKey = 'r_g_id';
	public $timestamps = false;

	protected $casts = [
		'r_g_r_t_id' => 'int',
		'r_g_shift' => 'int',
		'r_g_jam' => 'time without time zone',
		'r_g_m_produk_id' => 'int',
		'r_g_m_jenis_produk_id' => 'int',
		'r_g_m_menu_harga_nominal' => 'float',
		'r_g_qty' => 'int',
		'r_g_nominal' => 'float',
		'r_g_m_w_id' => 'int',
		'r_g_m_area_id' => 'int',
		'r_g_kasir_id' => 'int',
		'r_g_created_by' => 'int',
		'r_g_updated_by' => 'int'
	];

	protected $dates = [
		'r_g_tanggal',
		'r_g_created_at',
		'r_g_updated_at',
		'r_g_deleted_at'
	];

	protected $fillable = [
		'r_g_r_t_id',
		'r_g_tanggal',
		'r_g_shift',
		'r_g_jam',
		'r_g_nota_code',
		'r_g_m_produk_id',
		'r_g_m_produk_nama',
		'r_g_m_menu_cr',
		'r_g_m_menu_urut',
		'r_g_m_jenis_produk_id',
		'r_g_m_jenis_produk_nama',
		'r_g_m_menu_harga_nominal',
		'r_g_qty',
		'r_g_nominal',
		'r_g_keterangan',
		'r_g_action',
		'r_g_m_w_id',
		'r_g_m_w_nama',
		'r_g_m_area_id',
		'r_g_m_area_nama',
		'r_g_kasir_id',
		'r_g_kasir_nama',
		'r_g_status_sync',
		'r_g_created_by',
		'r_g_updated_by',
		'r_g_created_at',
		'r_g_updated_at',
		'r_g_deleted_at'
	];
}
