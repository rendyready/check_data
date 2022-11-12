<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigSubMenuJeni
 * 
 * @property int $id
 * @property int $config_sub_menu_jenis_m_menu_id
 * @property int $config_sub_menu_jenis_m_kategori_id
 * @property int $config_sub_menu_jenis_created_by
 * @property Carbon $config_sub_menu_jenis_created_at
 * @property Carbon|null $config_sub_menu_jenis_updated_at
 * @property Carbon|null $config_sub_menu_jenis_deleted_at
 *
 * @package App\Models
 */
class ConfigSubMenuJeni extends Model
{
	protected $table = 'config_sub_menu_jenis';
	public $timestamps = false;

	protected $casts = [
		'config_sub_menu_jenis_m_menu_id' => 'int',
		'config_sub_menu_jenis_m_kategori_id' => 'int',
		'config_sub_menu_jenis_created_by' => 'int'
	];

	protected $dates = [
		'config_sub_menu_jenis_created_at',
		'config_sub_menu_jenis_updated_at',
		'config_sub_menu_jenis_deleted_at'
	];

	protected $fillable = [
		'config_sub_menu_jenis_m_menu_id',
		'config_sub_menu_jenis_m_kategori_id',
		'config_sub_menu_jenis_created_by',
		'config_sub_menu_jenis_created_at',
		'config_sub_menu_jenis_updated_at',
		'config_sub_menu_jenis_deleted_at'
	];
}
