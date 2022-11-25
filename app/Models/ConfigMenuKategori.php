<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigMenuKategori
 * 
 * @property int $id
 * @property int $config_menu_kategori_m_menu_id
 * @property int $config_menu_kategori_m_kategori_id
 * @property int $config_menu_kategori_created_by
 * @property Carbon $config_menu_kategori_created_at
 * @property Carbon|null $config_menu_kategori_updated_at
 * @property Carbon|null $config_menu_kategori_deleted_at
 *
 * @package App\Models
 */
class ConfigMenuKategori extends Model
{
	protected $table = 'config_menu_kategori';
	public $timestamps = false;

	protected $casts = [
		'config_menu_kategori_m_menu_id' => 'int',
		'config_menu_kategori_m_kategori_id' => 'int',
		'config_menu_kategori_created_by' => 'int'
	];

	protected $dates = [
		'config_menu_kategori_created_at',
		'config_menu_kategori_updated_at',
		'config_menu_kategori_deleted_at'
	];

	protected $fillable = [
		'config_menu_kategori_m_menu_id',
		'config_menu_kategori_m_kategori_id',
		'config_menu_kategori_created_by',
		'config_menu_kategori_created_at',
		'config_menu_kategori_updated_at',
		'config_menu_kategori_deleted_at'
	];
}
