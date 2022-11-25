<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTransaksi
 * 
 * @property int $r_t_id
 * @property int $r_t_m_jenis_nota_id
 * @property string $r_t_m_jenis_nota_nama
 * @property string $r_t_nota_code
 * @property int $r_t_shift
 * @property Carbon $r_t_tanggal
 * @property time without time zone|null $r_t_jam
 * @property Carbon $r_t_jam_input
 * @property Carbon|null $r_t_jam_order
 * @property Carbon $r_t_jam_bayar
 * @property int|null $r_t_durasi_input
 * @property int|null $r_t_durasi_produksi
 * @property int|null $r_t_durasi_saji
 * @property int|null $r_t_durasi_pelayanan
 * @property int $r_t_durasi_kunjungan
 * @property int $r_t_config_meja_id
 * @property string $r_t_config_meja_nama
 * @property int $r_t_m_meja_jenis_space
 * @property string $r_t_bigbos
 * @property int $r_t_m_area_id
 * @property string $r_t_m_area_nama
 * @property int $r_t_m_w_id
 * @property string $r_t_m_w_nama
 * @property float $r_t_nominal_menu
 * @property float $r_t_nominal_pajak_menu
 * @property float $r_t_nominal_non_menu
 * @property float $r_t_nominal_pajak_non_menu
 * @property float $r_t_nominal_lain
 * @property float $r_t_nominal_pajak_lain
 * @property float $r_t_nominal
 * @property float $r_t_nominal_pajak
 * @property float $r_t_nominal_plus_pajak
 * @property float $r_t_nominal_potongan
 * @property float $r_t_nominal_diskon
 * @property float $r_t_nominal_voucher
 * @property float $r_t_nominal_sc
 * @property float $r_t_nominal_pembulatan
 * @property float $r_t_nominal_total_bayar
 * @property float $r_t_nominal_total_uang
 * @property float $r_t_nominal_void
 * @property float $r_t_nominal_void_pajak
 * @property float $r_t_nominal_void_sc
 * @property float $r_t_nominal_pembulatan_void
 * @property float $r_t_nominal_free_kembalian_void
 * @property int|null $r_t_void_counter
 * @property float $r_t_nominal_kembalian
 * @property float $r_t_nominal_free_kembalian
 * @property float $r_t_nominal_total_kembalian
 * @property float $r_t_nominal_tarik_tunai
 * @property float $r_t_pajak
 * @property float $r_t_diskon
 * @property float $r_t_sc
 * @property int $r_t_m_t_t_id
 * @property string $r_t_m_t_t_name
 * @property float $r_t_m_t_t_profit_price
 * @property float $r_t_m_t_t_profit_in
 * @property float $r_t_m_t_t_profit_out
 * @property string|null $r_t_tax_status
 * @property string $r_t_status
 * @property string|null $r_t_catatan
 * @property string $r_t_kasir_id
 * @property string $r_t_kasir_nama
 * @property string|null $r_t_ops_id
 * @property string|null $r_t_ops_nama
 * @property string $r_t_status_sync
 * @property int $r_t_created_by
 * @property int|null $r_t_updated_by
 * @property Carbon $r_t_created_at
 * @property Carbon|null $r_t_updated_at
 * @property Carbon|null $r_t_deleted_at
 *
 * @package App\Models
 */
class RekapTransaksi extends Model
{
	protected $table = 'rekap_transaksi';
	protected $primaryKey = 'r_t_id';
	public $timestamps = false;

	protected $casts = [
		'r_t_m_jenis_nota_id' => 'int',
		'r_t_shift' => 'int',
		'r_t_jam' => 'time without time zone',
		'r_t_durasi_input' => 'int',
		'r_t_durasi_produksi' => 'int',
		'r_t_durasi_saji' => 'int',
		'r_t_durasi_pelayanan' => 'int',
		'r_t_durasi_kunjungan' => 'int',
		'r_t_config_meja_id' => 'int',
		'r_t_m_meja_jenis_space' => 'int',
		'r_t_m_area_id' => 'int',
		'r_t_m_w_id' => 'int',
		'r_t_nominal_menu' => 'float',
		'r_t_nominal_pajak_menu' => 'float',
		'r_t_nominal_non_menu' => 'float',
		'r_t_nominal_pajak_non_menu' => 'float',
		'r_t_nominal_lain' => 'float',
		'r_t_nominal_pajak_lain' => 'float',
		'r_t_nominal' => 'float',
		'r_t_nominal_pajak' => 'float',
		'r_t_nominal_plus_pajak' => 'float',
		'r_t_nominal_potongan' => 'float',
		'r_t_nominal_diskon' => 'float',
		'r_t_nominal_voucher' => 'float',
		'r_t_nominal_sc' => 'float',
		'r_t_nominal_pembulatan' => 'float',
		'r_t_nominal_total_bayar' => 'float',
		'r_t_nominal_total_uang' => 'float',
		'r_t_nominal_void' => 'float',
		'r_t_nominal_void_pajak' => 'float',
		'r_t_nominal_void_sc' => 'float',
		'r_t_nominal_pembulatan_void' => 'float',
		'r_t_nominal_free_kembalian_void' => 'float',
		'r_t_void_counter' => 'int',
		'r_t_nominal_kembalian' => 'float',
		'r_t_nominal_free_kembalian' => 'float',
		'r_t_nominal_total_kembalian' => 'float',
		'r_t_nominal_tarik_tunai' => 'float',
		'r_t_pajak' => 'float',
		'r_t_diskon' => 'float',
		'r_t_sc' => 'float',
		'r_t_m_t_t_id' => 'int',
		'r_t_m_t_t_profit_price' => 'float',
		'r_t_m_t_t_profit_in' => 'float',
		'r_t_m_t_t_profit_out' => 'float',
		'r_t_created_by' => 'int',
		'r_t_updated_by' => 'int'
	];

	protected $dates = [
		'r_t_tanggal',
		'r_t_jam_input',
		'r_t_jam_order',
		'r_t_jam_bayar',
		'r_t_created_at',
		'r_t_updated_at',
		'r_t_deleted_at'
	];

	protected $fillable = [
		'r_t_m_jenis_nota_id',
		'r_t_m_jenis_nota_nama',
		'r_t_nota_code',
		'r_t_shift',
		'r_t_tanggal',
		'r_t_jam',
		'r_t_jam_input',
		'r_t_jam_order',
		'r_t_jam_bayar',
		'r_t_durasi_input',
		'r_t_durasi_produksi',
		'r_t_durasi_saji',
		'r_t_durasi_pelayanan',
		'r_t_durasi_kunjungan',
		'r_t_config_meja_id',
		'r_t_config_meja_nama',
		'r_t_m_meja_jenis_space',
		'r_t_bigbos',
		'r_t_m_area_id',
		'r_t_m_area_nama',
		'r_t_m_w_id',
		'r_t_m_w_nama',
		'r_t_nominal_menu',
		'r_t_nominal_pajak_menu',
		'r_t_nominal_non_menu',
		'r_t_nominal_pajak_non_menu',
		'r_t_nominal_lain',
		'r_t_nominal_pajak_lain',
		'r_t_nominal',
		'r_t_nominal_pajak',
		'r_t_nominal_plus_pajak',
		'r_t_nominal_potongan',
		'r_t_nominal_diskon',
		'r_t_nominal_voucher',
		'r_t_nominal_sc',
		'r_t_nominal_pembulatan',
		'r_t_nominal_total_bayar',
		'r_t_nominal_total_uang',
		'r_t_nominal_void',
		'r_t_nominal_void_pajak',
		'r_t_nominal_void_sc',
		'r_t_nominal_pembulatan_void',
		'r_t_nominal_free_kembalian_void',
		'r_t_void_counter',
		'r_t_nominal_kembalian',
		'r_t_nominal_free_kembalian',
		'r_t_nominal_total_kembalian',
		'r_t_nominal_tarik_tunai',
		'r_t_pajak',
		'r_t_diskon',
		'r_t_sc',
		'r_t_m_t_t_id',
		'r_t_m_t_t_name',
		'r_t_m_t_t_profit_price',
		'r_t_m_t_t_profit_in',
		'r_t_m_t_t_profit_out',
		'r_t_tax_status',
		'r_t_status',
		'r_t_catatan',
		'r_t_kasir_id',
		'r_t_kasir_nama',
		'r_t_ops_id',
		'r_t_ops_nama',
		'r_t_status_sync',
		'r_t_created_by',
		'r_t_updated_by',
		'r_t_created_at',
		'r_t_updated_at',
		'r_t_deleted_at'
	];
}
