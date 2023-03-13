<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MMenuHarga
 * 
 * @property int $id
 * @property int $m_menu_harga_id
 * @property float $m_menu_harga_nominal
 * @property int $m_menu_harga_m_jenis_nota_id
 * @property int $m_menu_harga_m_produk_id
 * @property string $m_menu_harga_status
 * @property string $m_menu_harga_tax_status
 * @property string $m_menu_harga_sc_status
 * @property int $m_menu_harga_created_by
 * @property int|null $m_menu_harga_updated_by
 * @property int|null $m_menu_harga_deleted_by
 * @property Carbon $m_menu_harga_created_at
 * @property Carbon|null $m_menu_harga_updated_at
 * @property Carbon|null $m_menu_harga_deleted_at
 *
 * @package App\Models
 */
class MMenuHarga extends Model
{
	protected $table = 'm_menu_harga';
	public $timestamps = false;

	protected $casts = [
		'm_menu_harga_id' => 'int',
		'm_menu_harga_nominal' => 'float',
		'm_menu_harga_m_jenis_nota_id' => 'int',
		'm_menu_harga_m_produk_id' => 'int',
		'm_menu_harga_created_by' => 'int',
		'm_menu_harga_updated_by' => 'int',
		'm_menu_harga_deleted_by' => 'int'
	];

	protected $dates = [
		'm_menu_harga_created_at',
		'm_menu_harga_updated_at',
		'm_menu_harga_deleted_at'
	];

	protected $fillable = [
		'm_menu_harga_id',
		'm_menu_harga_nominal',
		'm_menu_harga_m_jenis_nota_id',
		'm_menu_harga_m_produk_id',
		'm_menu_harga_status',
		'm_menu_harga_tax_status',
		'm_menu_harga_sc_status',
		'm_menu_harga_created_by',
		'm_menu_harga_updated_by',
		'm_menu_harga_deleted_by',
		'm_menu_harga_created_at',
		'm_menu_harga_updated_at',
		'm_menu_harga_deleted_at'
	];
}
