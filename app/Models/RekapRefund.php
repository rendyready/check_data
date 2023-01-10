<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapRefund
 * 
 * @property int $r_r_id
 * @property int|null $r_r_sync_id
 * @property int $r_r_r_t_id
 * @property int $r_r_m_produk_id
 * @property string|null $r_r_m_produk_nama
 * @property float $r_r_price
 * @property int $r_r_qty
 * @property float $r_r_nominal
 * @property float $r_r_nominal_pajak
 * @property float $r_r_nominal_sc
 * @property float $r_r_nominal_sharing_profit_in
 * @property float $r_r_nominal_sharing_profit_out
 * @property string|null $r_r_keterangan
 * @property string $r_r_status_sync
 * @property int|null $r_r_approved_by
 * @property int $r_r_created_by
 * @property int|null $r_r_updated_by
 * @property int|null $r_r_deleted_by
 * @property Carbon $r_r_created_at
 * @property Carbon|null $r_r_updated_at
 * @property Carbon|null $r_r_deleted_at
 *
 * @package App\Models
 */
class RekapRefund extends Model
{
	protected $table = 'rekap_refund';
	protected $primaryKey = 'r_r_id';
	public $timestamps = false;

	protected $casts = [
		'r_r_sync_id' => 'int',
		'r_r_r_t_id' => 'int',
		'r_r_m_produk_id' => 'int',
		'r_r_price' => 'float',
		'r_r_qty' => 'int',
		'r_r_nominal' => 'float',
		'r_r_nominal_pajak' => 'float',
		'r_r_nominal_sc' => 'float',
		'r_r_nominal_sharing_profit_in' => 'float',
		'r_r_nominal_sharing_profit_out' => 'float',
		'r_r_approved_by' => 'int',
		'r_r_created_by' => 'int',
		'r_r_updated_by' => 'int',
		'r_r_deleted_by' => 'int'
	];

	protected $dates = [
		'r_r_created_at',
		'r_r_updated_at',
		'r_r_deleted_at'
	];

	protected $fillable = [
		'r_r_sync_id',
		'r_r_r_t_id',
		'r_r_m_produk_id',
		'r_r_m_produk_nama',
		'r_r_price',
		'r_r_qty',
		'r_r_nominal',
		'r_r_nominal_pajak',
		'r_r_nominal_sc',
		'r_r_nominal_sharing_profit_in',
		'r_r_nominal_sharing_profit_out',
		'r_r_keterangan',
		'r_r_status_sync',
		'r_r_approved_by',
		'r_r_created_by',
		'r_r_updated_by',
		'r_r_deleted_by',
		'r_r_created_at',
		'r_r_updated_at',
		'r_r_deleted_at'
	];
}
