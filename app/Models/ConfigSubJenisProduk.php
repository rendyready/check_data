<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigSubJenisProduk
 * 
 * @property int $id
 * @property int $config_sub_jenis_produk_id
 * @property int $config_sub_jenis_produk_m_produk_id
 * @property int $config_sub_jenis_produk_m_sub_jenis_produk_id
 * @property int $config_sub_jenis_produk_created_by
 * @property int|null $config_sub_jenis_produk_updated_by
 * @property int|null $config_sub_jenis_produk_deleted_by
 * @property Carbon $config_sub_jenis_produk_created_at
 * @property Carbon|null $config_sub_jenis_produk_updated_at
 * @property Carbon|null $config_sub_jenis_produk_deleted_at
 * @property string $config_sub_jenis_produk_status_sync
 *
 * @package App\Models
 */
class ConfigSubJenisProduk extends Model
{
	protected $table = 'config_sub_jenis_produk';
	public $timestamps = false;

	protected $casts = [
		'config_sub_jenis_produk_id' => 'int',
		'config_sub_jenis_produk_m_produk_id' => 'int',
		'config_sub_jenis_produk_m_sub_jenis_produk_id' => 'int',
		'config_sub_jenis_produk_created_by' => 'int',
		'config_sub_jenis_produk_updated_by' => 'int',
		'config_sub_jenis_produk_deleted_by' => 'int',
		'config_sub_jenis_produk_created_at' => 'datetime',
		'config_sub_jenis_produk_updated_at' => 'datetime',
		'config_sub_jenis_produk_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'config_sub_jenis_produk_id',
		'config_sub_jenis_produk_m_produk_id',
		'config_sub_jenis_produk_m_sub_jenis_produk_id',
		'config_sub_jenis_produk_created_by',
		'config_sub_jenis_produk_updated_by',
		'config_sub_jenis_produk_deleted_by',
		'config_sub_jenis_produk_created_at',
		'config_sub_jenis_produk_updated_at',
		'config_sub_jenis_produk_deleted_at',
		'config_sub_jenis_produk_status_sync'
	];
}
