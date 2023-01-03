<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapVoid
 * 
 * @property int $r_v_id
 * @property int|null $r_v_sync_id
 * @property int $r_v_r_t_id
 * @property int $r_v_m_produk_id
 * @property float $r_v_price
 * @property int $r_v_qty
 * @property float $r_v_nominal
 * @property float $r_v_nominal_pajak
 * @property float $r_v_nominal_sc
 * @property float $r_v_nominal_sharing_profit
 * @property string $r_v_keterangan
 * @property string $r_v_status_sync
 * @property int $r_v_created_by
 * @property int|null $r_v_updated_by
 * @property int|null $r_v_deleted_by
 * @property Carbon $r_v_created_at
 * @property Carbon|null $r_v_updated_at
 * @property Carbon|null $r_v_deleted_at
 *
 * @package App\Models
 */
class RekapVoid extends Model
{
	protected $table = 'rekap_void';
	protected $primaryKey = 'r_v_id';
	public $timestamps = false;

	protected $casts = [
		'r_v_sync_id' => 'int',
		'r_v_r_t_id' => 'int',
		'r_v_m_produk_id' => 'int',
		'r_v_price' => 'float',
		'r_v_qty' => 'int',
		'r_v_nominal' => 'float',
		'r_v_nominal_pajak' => 'float',
		'r_v_nominal_sc' => 'float',
		'r_v_nominal_sharing_profit' => 'float',
		'r_v_approved_by' => 'int',
		'r_v_created_by' => 'int',
		'r_v_updated_by' => 'int',
		'r_v_deleted_by' => 'int'
	];

	protected $dates = [
		'r_v_created_at',
		'r_v_updated_at',
		'r_v_deleted_at'
	];

	protected $fillable = [
		'r_v_sync_id',
		'r_v_r_t_id',
		'r_v_m_produk_id',
		'r_v_price',
		'r_v_qty',
		'r_v_nominal',
		'r_v_nominal_pajak',
		'r_v_nominal_sc',
		'r_v_nominal_sharing_profit',
		'r_v_keterangan',
		'r_v_status_sync',
		'r_v_approved_by',
		'r_v_created_by',
		'r_v_updated_by',
		'r_v_deleted_by',
		'r_v_created_at',
		'r_v_updated_at',
		'r_v_deleted_at'
	];
}
