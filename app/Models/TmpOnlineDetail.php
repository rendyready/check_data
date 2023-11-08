<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TmpOnlineDetail
 * 
 * @property uuid $tmp_online_detail_id
 * @property uuid $tmp_online_detail_tmp_online_id
 * @property int $tmp_online_detail_m_produk_id
 * @property string $tmp_online_detail_m_produk_nama
 * @property float $tmp_online_detail_price
 * @property int $tmp_online_detail_qty
 * @property float $tmp_online_detail_nominal
 * @property float $tmp_online_detail_tax
 * @property float $tmp_online_detail_service
 * @property string|null $tmp_online_detail_custom
 * @property string $tmp_online_detail_client_target
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TmpOnlineDetail extends Model
{
	protected $table = 'tmp_online_detail';
	protected $primaryKey = 'tmp_online_detail_id';
	public $incrementing = false;

	protected $casts = [
		'tmp_online_detail_id' => 'uuid',
		'tmp_online_detail_tmp_online_id' => 'uuid',
		'tmp_online_detail_m_produk_id' => 'int',
		'tmp_online_detail_price' => 'float',
		'tmp_online_detail_qty' => 'int',
		'tmp_online_detail_nominal' => 'float',
		'tmp_online_detail_tax' => 'float',
		'tmp_online_detail_service' => 'float'
	];

	protected $fillable = [
		'tmp_online_detail_tmp_online_id',
		'tmp_online_detail_m_produk_id',
		'tmp_online_detail_m_produk_nama',
		'tmp_online_detail_price',
		'tmp_online_detail_qty',
		'tmp_online_detail_nominal',
		'tmp_online_detail_tax',
		'tmp_online_detail_service',
		'tmp_online_detail_custom',
		'tmp_online_detail_client_target'
	];
}
