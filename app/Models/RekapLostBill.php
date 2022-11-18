<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapLostBill
 * 
 * @property int $r_l_b_id
 * @property int $r_l_b_r_t_id
 * @property Carbon $r_l_b_tanggal
 * @property int $r_l_b_shift
 * @property time without time zone $r_l_b_jam
 * @property string $r_l_b_nota_code
 * @property int $r_l_b_m_produk_id
 * @property string $r_l_b_m_produk_nama
 * @property string $r_l_b_m_menu_cr
 * @property string $r_l_b_m_menu_urut
 * @property int $r_l_b_m_jenis_produk_id
 * @property string $r_l_b_m_jenis_produk_nama
 * @property float $r_l_b_m_menu_harga_nominal
 * @property int $r_l_b_qty
 * @property float $r_l_b_nominal
 * @property string $r_l_b_keterangan
 * @property int $r_l_b_m_w_id
 * @property string $r_l_b_m_w_nama
 * @property int $r_l_b_m_area_id
 * @property string $r_l_b_m_area_nama
 * @property int $r_l_b_kasir_id
 * @property string $r_l_b_kasir_nama
 * @property string $r_l_b_status_sync
 * @property int $r_l_b_ops_id
 * @property string $r_l_b_ops_nama
 * @property int $r_l_b_created_by
 * @property int|null $r_l_b_updated_by
 * @property Carbon $r_l_b_created_at
 * @property Carbon|null $r_l_b_updated_at
 * @property Carbon|null $r_l_b_deleted_at
 *
 * @package App\Models
 */
class RekapLostBill extends Model
{
	protected $table = 'rekap_lost_bill';
	protected $primaryKey = 'r_l_b_id';
	public $timestamps = false;

	protected $casts = [
		'r_l_b_r_t_id' => 'int',
		'r_l_b_shift' => 'int',
		'r_l_b_jam' => 'time without time zone',
		'r_l_b_m_produk_id' => 'int',
		'r_l_b_m_jenis_produk_id' => 'int',
		'r_l_b_m_menu_harga_nominal' => 'float',
		'r_l_b_qty' => 'int',
		'r_l_b_nominal' => 'float',
		'r_l_b_m_w_id' => 'int',
		'r_l_b_m_area_id' => 'int',
		'r_l_b_kasir_id' => 'int',
		'r_l_b_ops_id' => 'int',
		'r_l_b_created_by' => 'int',
		'r_l_b_updated_by' => 'int'
	];

	protected $dates = [
		'r_l_b_tanggal',
		'r_l_b_created_at',
		'r_l_b_updated_at',
		'r_l_b_deleted_at'
	];

	protected $fillable = [
		'r_l_b_r_t_id',
		'r_l_b_tanggal',
		'r_l_b_shift',
		'r_l_b_jam',
		'r_l_b_nota_code',
		'r_l_b_m_produk_id',
		'r_l_b_m_produk_nama',
		'r_l_b_m_menu_cr',
		'r_l_b_m_menu_urut',
		'r_l_b_m_jenis_produk_id',
		'r_l_b_m_jenis_produk_nama',
		'r_l_b_m_menu_harga_nominal',
		'r_l_b_qty',
		'r_l_b_nominal',
		'r_l_b_keterangan',
		'r_l_b_m_w_id',
		'r_l_b_m_w_nama',
		'r_l_b_m_area_id',
		'r_l_b_m_area_nama',
		'r_l_b_kasir_id',
		'r_l_b_kasir_nama',
		'r_l_b_status_sync',
		'r_l_b_ops_id',
		'r_l_b_ops_nama',
		'r_l_b_created_by',
		'r_l_b_updated_by',
		'r_l_b_created_at',
		'r_l_b_updated_at',
		'r_l_b_deleted_at'
	];
}
