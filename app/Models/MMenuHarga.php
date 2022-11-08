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
 * @property float $m_menu_harga_nominal
 * @property int $m_menu_harga_m_jenis_nota_id
 * @property int $m_menu_harga_m_menu_id
 * @property string $m_menu_harga_status
 * @property int $m_menu_harga_created_by
 * @property Carbon $m_menu_harga_created_at
 * @property int|null $m_menu_harga_updated_by
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
		'm_menu_harga_nominal' => 'float',
		'm_menu_harga_m_jenis_nota_id' => 'int',
		'm_menu_harga_m_menu_id' => 'int',
		'm_menu_harga_created_by' => 'int',
		'm_menu_harga_updated_by' => 'int'
	];

	protected $dates = [
		'm_menu_harga_created_at',
		'm_menu_harga_updated_at',
		'm_menu_harga_deleted_at'
	];

	protected $fillable = [
		'm_menu_harga_nominal',
		'm_menu_harga_m_jenis_nota_id',
		'm_menu_harga_m_menu_id',
		'm_menu_harga_status',
		'm_menu_harga_created_by',
		'm_menu_harga_created_at',
		'm_menu_harga_updated_by',
		'm_menu_harga_updated_at',
		'm_menu_harga_deleted_at'
	];
}
