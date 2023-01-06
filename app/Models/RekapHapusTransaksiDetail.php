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
 * @property int $r_h_t_detail_id
 * @property int|null $r_h_t_detail_sync_id
 * @property int $r_h_t_detail_r_h_t_id
 * @property int $r_h_t_detail_m_produk_id
 * @property int $r_h_t_detail_qty
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
	protected $primaryKey = 'r_h_t_detail_id';
	public $timestamps = false;

	protected $casts = [
		'r_h_t_detail_sync_id' => 'int',
		'r_h_t_detail_r_h_t_id' => 'int',
		'r_h_t_detail_m_produk_id' => 'int',
		'r_h_t_detail_qty' => 'int',
		'r_h_t_detail_price' => 'float',
		'r_h_t_detail_nominal' => 'float',
		'r_h_t_detail_nominal_pajak' => 'float',
		'r_h_t_detail_nominal_sc' => 'float',
		'r_h_t_detail_nominal_sharing_profit_in' => 'float',
		'r_h_t_detail_nominal_sharing_profit_out' => 'float',
		'r_h_t_detail_created_by' => 'int',
		'r_h_t_detail_updated_by' => 'int',
		'r_h_t_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'r_h_t_detail_created_at',
		'r_h_t_detail_updated_at',
		'r_h_t_detail_deleted_at'
	];

	protected $fillable = [
		'r_h_t_detail_sync_id',
		'r_h_t_detail_r_h_t_id',
		'r_h_t_detail_m_produk_id',
		'r_h_t_detail_qty',
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
