<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapRefundDetail
 * 
 * @property int $id
 * @property string $r_r_detail_id
 * @property string $r_r_detail_r_r_id
 * @property int $r_r_detail_m_produk_id
 * @property string|null $r_r_detail_m_produk_code
 * @property string|null $r_r_detail_m_produk_nama
 * @property float $r_r_detail_reguler_price
 * @property float $r_r_detail_price
 * @property int $r_r_detail_qty
 * @property float $r_r_detail_nominal
 * @property float $r_r_detail_nominal_pajak
 * @property float $r_r_detail_nominal_sc
 * @property float $r_r_detail_nominal_sharing_profit_in
 * @property float $r_r_detail_nominal_sharing_profit_out
 * @property string $r_r_detail_status_sync
 * @property int|null $r_r_detail_approved_by
 * @property int $r_r_detail_created_by
 * @property int|null $r_r_detail_updated_by
 * @property int|null $r_r_detail_deleted_by
 * @property Carbon $r_r_detail_created_at
 * @property Carbon|null $r_r_detail_updated_at
 * @property Carbon|null $r_r_detail_deleted_at
 *
 * @package App\Models
 */
class RekapRefundDetail extends Model
{
	protected $table = 'rekap_refund_detail';
	public $timestamps = false;

	protected $casts = [
		'r_r_detail_m_produk_id' => 'int',
		'r_r_detail_reguler_price' => 'float',
		'r_r_detail_price' => 'float',
		'r_r_detail_qty' => 'int',
		'r_r_detail_nominal' => 'float',
		'r_r_detail_nominal_pajak' => 'float',
		'r_r_detail_nominal_sc' => 'float',
		'r_r_detail_nominal_sharing_profit_in' => 'float',
		'r_r_detail_nominal_sharing_profit_out' => 'float',
		'r_r_detail_approved_by' => 'int',
		'r_r_detail_created_by' => 'int',
		'r_r_detail_updated_by' => 'int',
		'r_r_detail_deleted_by' => 'int',
		'r_r_detail_created_at' => 'datetime',
		'r_r_detail_updated_at' => 'datetime',
		'r_r_detail_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'r_r_detail_id',
		'r_r_detail_r_r_id',
		'r_r_detail_m_produk_id',
		'r_r_detail_m_produk_code',
		'r_r_detail_m_produk_nama',
		'r_r_detail_reguler_price',
		'r_r_detail_price',
		'r_r_detail_qty',
		'r_r_detail_nominal',
		'r_r_detail_nominal_pajak',
		'r_r_detail_nominal_sc',
		'r_r_detail_nominal_sharing_profit_in',
		'r_r_detail_nominal_sharing_profit_out',
		'r_r_detail_status_sync',
		'r_r_detail_approved_by',
		'r_r_detail_created_by',
		'r_r_detail_updated_by',
		'r_r_detail_deleted_by',
		'r_r_detail_created_at',
		'r_r_detail_updated_at',
		'r_r_detail_deleted_at'
	];
}
