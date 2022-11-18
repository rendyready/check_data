<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MSubMenuJeni
 * 
 * @property int $id
 * @property string $m_sub_menu_jenis_nama
 * @property int $m_sub_menu_jenis_m_menu_jenis_id
 * @property int $m_sub_menu_jenis_created_by
 * @property Carbon $m_sub_menu_jenis_created_at
 * @property int|null $m_sub_menu_jenis_updated_by
 * @property Carbon|null $m_sub_menu_jenis_updated_at
 * @property Carbon|null $m_sub_menu_jenis_deleted_at
 *
 * @package App\Models
 */
class MSubMenuJeni extends Model
{
	protected $table = 'm_sub_menu_jenis';
	public $timestamps = false;

	protected $casts = [
		'm_sub_menu_jenis_m_menu_jenis_id' => 'int',
		'm_sub_menu_jenis_created_by' => 'int',
		'm_sub_menu_jenis_updated_by' => 'int'
	];

	protected $dates = [
		'm_sub_menu_jenis_created_at',
		'm_sub_menu_jenis_updated_at',
		'm_sub_menu_jenis_deleted_at'
	];

	protected $fillable = [
		'm_sub_menu_jenis_nama',
		'm_sub_menu_jenis_m_menu_jenis_id',
		'm_sub_menu_jenis_created_by',
		'm_sub_menu_jenis_created_at',
		'm_sub_menu_jenis_updated_by',
		'm_sub_menu_jenis_updated_at',
		'm_sub_menu_jenis_deleted_at'
	];
}
