<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapHapusTransaksi
 * 
 * @property int $r_h_t_id
 * @property int $r_h_t_m_jenis_nota_id
 * @property string $r_h_t_m_jenis_nota_nama
 * @property string $r_h_t_nota_code
 * @property int $r_h_t_shift
 * @property Carbon $r_h_t_tanggal
 * @property time without time zone $r_h_t_jam_hapus
 * @property int $r_h_t_config_meja_id
 * @property string $r_h_t_config_meja_nama
 * @property string $r_h_t_bigbos
 * @property int $r_h_t_m_area_id
 * @property string $r_h_t_m_area_nama
 * @property int $r_h_t_m_w_id
 * @property string $r_h_t_m_w_nama
 * @property float $r_h_t_nominal_total_bayar
 * @property int $r_h_t_m_t_t_id
 * @property string $r_h_t_m_t_t_name
 * @property float $r_h_t_m_t_t_profit_price
 * @property float $r_h_t_m_t_t_profit_in
 * @property float $r_h_t_m_t_t_profit_out
 * @property string $r_h_t_status_sync
 * @property int $r_h_t_kasir_id
 * @property string $r_h_t_kasir_nama
 * @property int $r_h_t_created_by
 * @property int|null $r_h_t_updated_by
 * @property Carbon $r_h_t_created_at
 * @property Carbon|null $r_h_t_updated_at
 * @property Carbon|null $r_h_t_deleted_at
 *
 * @package App\Models
 */
class RekapHapusTransaksi extends Model
{
	protected $table = 'rekap_hapus_transaksi';
	protected $primaryKey = 'r_h_t_id';
	public $timestamps = false;

	protected $casts = [
		'r_h_t_m_jenis_nota_id' => 'int',
		'r_h_t_shift' => 'int',
		'r_h_t_jam_hapus' => 'time without time zone',
		'r_h_t_config_meja_id' => 'int',
		'r_h_t_m_area_id' => 'int',
		'r_h_t_m_w_id' => 'int',
		'r_h_t_nominal_total_bayar' => 'float',
		'r_h_t_m_t_t_id' => 'int',
		'r_h_t_m_t_t_profit_price' => 'float',
		'r_h_t_m_t_t_profit_in' => 'float',
		'r_h_t_m_t_t_profit_out' => 'float',
		'r_h_t_kasir_id' => 'int',
		'r_h_t_created_by' => 'int',
		'r_h_t_updated_by' => 'int'
	];

	protected $dates = [
		'r_h_t_tanggal',
		'r_h_t_created_at',
		'r_h_t_updated_at',
		'r_h_t_deleted_at'
	];

	protected $fillable = [
		'r_h_t_m_jenis_nota_id',
		'r_h_t_m_jenis_nota_nama',
		'r_h_t_nota_code',
		'r_h_t_shift',
		'r_h_t_tanggal',
		'r_h_t_jam_hapus',
		'r_h_t_config_meja_id',
		'r_h_t_config_meja_nama',
		'r_h_t_bigbos',
		'r_h_t_m_area_id',
		'r_h_t_m_area_nama',
		'r_h_t_m_w_id',
		'r_h_t_m_w_nama',
		'r_h_t_nominal_total_bayar',
		'r_h_t_m_t_t_id',
		'r_h_t_m_t_t_name',
		'r_h_t_m_t_t_profit_price',
		'r_h_t_m_t_t_profit_in',
		'r_h_t_m_t_t_profit_out',
		'r_h_t_status_sync',
		'r_h_t_kasir_id',
		'r_h_t_kasir_nama',
		'r_h_t_created_by',
		'r_h_t_updated_by',
		'r_h_t_created_at',
		'r_h_t_updated_at',
		'r_h_t_deleted_at'
	];
}
