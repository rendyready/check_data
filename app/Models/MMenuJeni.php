<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MMenuJeni
 * 
 * @property int $id
 * @property string $m_menu_jenis_nama
 * @property string $m_menu_jenis_urut
 * @property string|null $m_menu_jenis_odcr55
 * @property int $m_menu_jenis_created_by
 * @property Carbon $m_menu_jenis_created_at
 * @property int|null $m_menu_jenis_updated_by
 * @property Carbon|null $m_menu_jenis_updated_at
 * @property Carbon|null $m_menu_jenis_deleted_at
 *
 * @package App\Models
 */
class MMenuJeni extends Model
{
	protected $table = 'm_menu_jenis';
	public $timestamps = false;

	protected $casts = [
		'm_menu_jenis_created_by' => 'int',
		'm_menu_jenis_updated_by' => 'int'
	];

	protected $dates = [
		'm_menu_jenis_created_at',
		'm_menu_jenis_updated_at',
		'm_menu_jenis_deleted_at'
	];

	protected $fillable = [
		'm_menu_jenis_nama',
		'm_menu_jenis_urut',
		'm_menu_jenis_odcr55',
		'm_menu_jenis_created_by',
		'm_menu_jenis_created_at',
		'm_menu_jenis_updated_by',
		'm_menu_jenis_updated_at',
		'm_menu_jenis_deleted_at'
	];
}
