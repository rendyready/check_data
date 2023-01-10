<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TmpTransactionDetail
 * 
 * @property uuid $tmp_transaction_detail_id
 * @property uuid $tmp_transaction_detail_tmp_transaction_id
 * @property int|null $tmp_transaction_detail_m_produk_id
 * @property int $tmp_transaction_detail_qty
 * @property int|null $tmp_transaction_detail_created_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $tmp_transaction_detail_status
 * @property int|null $tmp_transaction_detail_qty_approve
 * @property string|null $tmp_transaction_detail_reasone_approve
 * @property float $tmp_transaction_detail_tax
 * @property float|null $tmp_transaction_detail_service_charge
 * @property float $tmp_transaction_detail_discount
 * @property float $tmp_transaction_detail_price
 * @property float $tmp_transaction_detail_nominal
 * @property string|null $tmp_transaction_detail_custom_menu
 * @property bool $tmp_transaction_detail_tax_status
 * @property bool $tmp_transaction_detail_service_charge_status
 * @property int $tmp_transaction_detail_production_status
 * @property string $tmp_transaction_detail_discount_type
 *
 * @package App\Models
 */
class TmpTransactionDetail extends Model
{
	use SoftDeletes;
	protected $table = 'tmp_transaction_detail';
	protected $primaryKey = 'tmp_transaction_detail_id';
	public $incrementing = false;

	protected $casts = [
		'tmp_transaction_detail_id' => 'uuid',
		'tmp_transaction_detail_tmp_transaction_id' => 'uuid',
		'tmp_transaction_detail_m_produk_id' => 'int',
		'tmp_transaction_detail_qty' => 'int',
		'tmp_transaction_detail_created_by' => 'int',
		'tmp_transaction_detail_status' => 'int',
		'tmp_transaction_detail_qty_approve' => 'int',
		'tmp_transaction_detail_tax' => 'float',
		'tmp_transaction_detail_service_charge' => 'float',
		'tmp_transaction_detail_discount' => 'float',
		'tmp_transaction_detail_price' => 'float',
		'tmp_transaction_detail_nominal' => 'float',
		'tmp_transaction_detail_tax_status' => 'bool',
		'tmp_transaction_detail_service_charge_status' => 'bool',
		'tmp_transaction_detail_production_status' => 'int'
	];

	protected $fillable = [
		'tmp_transaction_detail_tmp_transaction_id',
		'tmp_transaction_detail_m_produk_id',
		'tmp_transaction_detail_qty',
		'tmp_transaction_detail_created_by',
		'tmp_transaction_detail_status',
		'tmp_transaction_detail_qty_approve',
		'tmp_transaction_detail_reasone_approve',
		'tmp_transaction_detail_tax',
		'tmp_transaction_detail_service_charge',
		'tmp_transaction_detail_discount',
		'tmp_transaction_detail_price',
		'tmp_transaction_detail_nominal',
		'tmp_transaction_detail_custom_menu',
		'tmp_transaction_detail_tax_status',
		'tmp_transaction_detail_service_charge_status',
		'tmp_transaction_detail_production_status',
		'tmp_transaction_detail_discount_type'
	];
}
