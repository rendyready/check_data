<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RphDetailMenu
 * 
 * @property int $id
 * @property string $rph_detail_menu_id
 * @property string $rph_detail_menu_rph_code
 * @property string $rph_detail_menu_m_produk_code
 * @property string $rph_detail_menu_m_produk_nama
 * @property float $rph_detail_menu_qty
 * @property int $rph_detail_menu_created_by
 * @property int|null $rph_detail_menu_updated_by
 * @property int|null $rph_detail_menu_deleted_by
 * @property Carbon $rph_detail_menu_created_at
 * @property Carbon|null $rph_detail_menu_updated_at
 * @property Carbon|null $rph_detail_menu_deleted_at
 *
 * @package App\Models
 */
class RphDetailMenu extends Model
{
	protected $table = 'rph_detail_menu';
	public $timestamps = false;

	protected $casts = [
		'rph_detail_menu_qty' => 'float',
		'rph_detail_menu_created_by' => 'int',
		'rph_detail_menu_updated_by' => 'int',
		'rph_detail_menu_deleted_by' => 'int',
		'rph_detail_menu_created_at' => 'datetime',
		'rph_detail_menu_updated_at' => 'datetime',
		'rph_detail_menu_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rph_detail_menu_id',
		'rph_detail_menu_rph_code',
		'rph_detail_menu_m_produk_code',
		'rph_detail_menu_m_produk_nama',
		'rph_detail_menu_qty',
		'rph_detail_menu_created_by',
		'rph_detail_menu_updated_by',
		'rph_detail_menu_deleted_by',
		'rph_detail_menu_created_at',
		'rph_detail_menu_updated_at',
		'rph_detail_menu_deleted_at'
	];
}
