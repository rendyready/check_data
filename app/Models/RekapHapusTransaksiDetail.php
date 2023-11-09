<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapHapusTransaksiDetail
 * 
 * @property int $id
 * @property string $r_h_t_detail_id
 * @property string $r_h_t_detail_r_h_t_id
 * @property int $r_h_t_detail_m_produk_id
 * @property string|null $r_h_t_detail_m_produk_code
 * @property string|null $r_h_t_detail_m_produk_nama
 * @property int $r_h_t_detail_qty
 * @property float $r_h_t_detail_reguler_price
 * @property float $r_h_t_detail_price
 * @property float $r_h_t_detail_nominal
 * @property float $r_h_t_detail_nominal_pajak
 * @property float $r_h_t_detail_nominal_sc
 * @property float $r_h_t_detail_nominal_sharing_profit_in
 * @property float $r_h_t_detail_nominal_sharing_profit_out
 * @property string $r_h_t_detail_status_sync
 * @property int $r_h_t_detail_created_by
 * @property int|null $r_h_t_detail_updated_by
 * @property int|null $r_h_t_detail_deleted_by
 * @property Carbon $r_h_t_detail_created_at
 * @property Carbon|null $r_h_t_detail_updated_at
 * @property Carbon|null $r_h_t_detail_deleted_at
 *
 * @package App\Models
 */
class RekapHapusTransaksiDetail extends Model
{
	protected $table = 'rekap_hapus_transaksi_detail';
	public $timestamps = false;

	protected $casts = [
		'r_h_t_detail_m_produk_id' => 'int',
		'r_h_t_detail_qty' => 'int',
		'r_h_t_detail_reguler_price' => 'float',
		'r_h_t_detail_price' => 'float',
		'r_h_t_detail_nominal' => 'float',
		'r_h_t_detail_nominal_pajak' => 'float',
		'r_h_t_detail_nominal_sc' => 'float',
		'r_h_t_detail_nominal_sharing_profit_in' => 'float',
		'r_h_t_detail_nominal_sharing_profit_out' => 'float',
		'r_h_t_detail_created_by' => 'int',
		'r_h_t_detail_updated_by' => 'int',
		'r_h_t_detail_deleted_by' => 'int',
		'r_h_t_detail_created_at' => 'datetime',
		'r_h_t_detail_updated_at' => 'datetime',
		'r_h_t_detail_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'r_h_t_detail_id',
		'r_h_t_detail_r_h_t_id',
		'r_h_t_detail_m_produk_id',
		'r_h_t_detail_m_produk_code',
		'r_h_t_detail_m_produk_nama',
		'r_h_t_detail_qty',
		'r_h_t_detail_reguler_price',
		'r_h_t_detail_price',
		'r_h_t_detail_nominal',
		'r_h_t_detail_nominal_pajak',
		'r_h_t_detail_nominal_sc',
		'r_h_t_detail_nominal_sharing_profit_in',
		'r_h_t_detail_nominal_sharing_profit_out',
		'r_h_t_detail_status_sync',
		'r_h_t_detail_created_by',
		'r_h_t_detail_updated_by',
		'r_h_t_detail_deleted_by',
		'r_h_t_detail_created_at',
		'r_h_t_detail_updated_at',
		'r_h_t_detail_deleted_at'
	];
}
