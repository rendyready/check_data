<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTransaksiDetail
 * 
 * @property int $r_t_detail_id
 * @property int|null $r_t_detail_sync_id
 * @property int $r_t_detail_r_t_id
 * @property int $r_t_detail_m_produk_id
 * @property string $r_t_detail_m_produk_nama
 * @property string $r_t_detail_custom
 * @property float $r_t_detail_price
 * @property int $r_t_detail_qty
 * @property float $r_t_detail_nominal
 * @property float $r_t_detail_nominal_pajak
 * @property float $r_t_detail_nominal_sc
 * @property float $r_t_detail_nominal_sharing_profit
 * @property string $r_t_detail_status_sync
 * @property int $r_t_detail_created_by
 * @property int|null $r_t_detail_updated_by
 * @property int|null $r_t_detail_deleted_by
 * @property Carbon $r_t_detail_created_at
 * @property Carbon|null $r_t_detail_updated_at
 * @property Carbon|null $r_t_detail_deleted_at
 *
 * @package App\Models
 */
class RekapTransaksiDetail extends Model
{
	protected $table = 'rekap_transaksi_detail';
	protected $primaryKey = 'r_t_detail_id';
	public $timestamps = false;

	protected $casts = [
		'r_t_detail_sync_id' => 'int',
		'r_t_detail_r_t_id' => 'int',
		'r_t_detail_m_produk_id' => 'int',
		'r_t_detail_price' => 'float',
		'r_t_detail_qty' => 'int',
		'r_t_detail_nominal' => 'float',
		'r_t_detail_nominal_pajak' => 'float',
		'r_t_detail_nominal_sc' => 'float',
		'r_t_detail_nominal_sharing_profit' => 'float',
		'r_t_detail_created_by' => 'int',
		'r_t_detail_updated_by' => 'int',
		'r_t_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'r_t_detail_created_at',
		'r_t_detail_updated_at',
		'r_t_detail_deleted_at'
	];

	protected $fillable = [
		'r_t_detail_sync_id',
		'r_t_detail_r_t_id',
		'r_t_detail_m_produk_id',
		'r_t_detail_m_produk_nama',
		'r_t_detail_custom',
		'r_t_detail_price',
		'r_t_detail_qty',
		'r_t_detail_nominal',
		'r_t_detail_nominal_pajak',
		'r_t_detail_nominal_sc',
		'r_t_detail_nominal_sharing_profit',
		'r_t_detail_status_sync',
		'r_t_detail_created_by',
		'r_t_detail_updated_by',
		'r_t_detail_deleted_by',
		'r_t_detail_created_at',
		'r_t_detail_updated_at',
		'r_t_detail_deleted_at'
	];
}
