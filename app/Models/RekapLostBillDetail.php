<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapLostBillDetail
 * 
 * @property int $r_l_b_detail_id
 * @property int|null $r_l_b_detail_sync_id
 * @property int $r_l_b_detail_r_l_b_id
 * @property int $r_l_b_detail_m_produk_id
 * @property float $r_l_b_detail_price
 * @property int $r_l_b_detail_qty
 * @property float $r_l_b_detail_nominal
 * @property float $r_l_b_detail_nominal_pajak
 * @property float $r_l_b_detail_nominal_sc
 * @property float $r_l_b_detail_nominal_sharing_profit_in
 * @property float $r_l_b_detail_nominal_sharing_profit_out
 * @property string $r_l_b_detail_status_sync
 * @property int $r_l_b_detail_created_by
 * @property int|null $r_l_b_detail_updated_by
 * @property int|null $r_l_b_detail_deleted_by
 * @property Carbon $r_l_b_detail_created_at
 * @property Carbon|null $r_l_b_detail_updated_at
 * @property Carbon|null $r_l_b_detail_deleted_at
 *
 * @package App\Models
 */
class RekapLostBillDetail extends Model
{
	protected $table = 'rekap_lost_bill_detail';
	protected $primaryKey = 'r_l_b_detail_id';
	public $timestamps = false;

	protected $casts = [
		'r_l_b_detail_sync_id' => 'int',
		'r_l_b_detail_r_l_b_id' => 'int',
		'r_l_b_detail_m_produk_id' => 'int',
		'r_l_b_detail_price' => 'float',
		'r_l_b_detail_qty' => 'int',
		'r_l_b_detail_nominal' => 'float',
		'r_l_b_detail_nominal_pajak' => 'float',
		'r_l_b_detail_nominal_sc' => 'float',
		'r_l_b_detail_nominal_sharing_profit_in' => 'float',
		'r_l_b_detail_nominal_sharing_profit_out' => 'float',
		'r_l_b_detail_created_by' => 'int',
		'r_l_b_detail_updated_by' => 'int',
		'r_l_b_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'r_l_b_detail_created_at',
		'r_l_b_detail_updated_at',
		'r_l_b_detail_deleted_at'
	];

	protected $fillable = [
		'r_l_b_detail_sync_id',
		'r_l_b_detail_r_l_b_id',
		'r_l_b_detail_m_produk_id',
		'r_l_b_detail_price',
		'r_l_b_detail_qty',
		'r_l_b_detail_nominal',
		'r_l_b_detail_nominal_pajak',
		'r_l_b_detail_nominal_sc',
		'r_l_b_detail_nominal_sharing_profit_in',
		'r_l_b_detail_nominal_sharing_profit_out',
		'r_l_b_detail_status_sync',
		'r_l_b_detail_created_by',
		'r_l_b_detail_updated_by',
		'r_l_b_detail_deleted_by',
		'r_l_b_detail_created_at',
		'r_l_b_detail_updated_at',
		'r_l_b_detail_deleted_at'
	];
}
