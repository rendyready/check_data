<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RphDetailBb
 * 
 * @property int $id
 * @property string $rph_detail_bb_id
 * @property string $rph_detail_bb_rph_code
 * @property string $rph_detail_bb_m_produk_code
 * @property string $rph_detail_bb_m_produk_nama
 * @property float $rph_detail_bb_qty
 * @property int $rph_detail_bb_created_by
 * @property int|null $rph_detail_bb_updated_by
 * @property int|null $rph_detail_bb_deleted_by
 * @property Carbon $rph_detail_bb_created_at
 * @property Carbon|null $rph_detail_bb_updated_at
 * @property Carbon|null $rph_detail_bb_deleted_at
 * @property string $rph_detail_bb_rph_detail_menu_id
 *
 * @package App\Models
 */
class RphDetailBb extends Model
{
	protected $table = 'rph_detail_bb';
	public $timestamps = false;

	protected $casts = [
		'rph_detail_bb_qty' => 'float',
		'rph_detail_bb_created_by' => 'int',
		'rph_detail_bb_updated_by' => 'int',
		'rph_detail_bb_deleted_by' => 'int',
		'rph_detail_bb_created_at' => 'datetime',
		'rph_detail_bb_updated_at' => 'datetime',
		'rph_detail_bb_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rph_detail_bb_id',
		'rph_detail_bb_rph_code',
		'rph_detail_bb_m_produk_code',
		'rph_detail_bb_m_produk_nama',
		'rph_detail_bb_qty',
		'rph_detail_bb_created_by',
		'rph_detail_bb_updated_by',
		'rph_detail_bb_deleted_by',
		'rph_detail_bb_created_at',
		'rph_detail_bb_updated_at',
		'rph_detail_bb_deleted_at',
		'rph_detail_bb_rph_detail_menu_id'
	];
}
