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
 * @property int $config_sub_jenis_produk_id
 * @property int $config_sub_jenis_produk_m_produk_id
 * @property int $config_sub_jenis_produk_m_kategori_id
 * @property int $config_sub_jenis_produk_created_by
 * @property Carbon $config_sub_jenis_produk_created_at
 * @property Carbon|null $config_sub_jenis_produk_updated_at
 * @property Carbon|null $config_sub_jenis_produk_deleted_at
 *
 * @package App\Models
 */
class ConfigSubJenisProduk extends Model
{
	protected $table = 'config_sub_jenis_produk';
	protected $primaryKey = 'config_sub_jenis_produk_id';
	public $timestamps = false;

	protected $casts = [
		'config_sub_jenis_produk_m_produk_id' => 'int',
		'config_sub_jenis_produk_m_kategori_id' => 'int',
		'config_sub_jenis_produk_created_by' => 'int'
	];

	protected $dates = [
		'config_sub_jenis_produk_created_at',
		'config_sub_jenis_produk_updated_at',
		'config_sub_jenis_produk_deleted_at'
	];

	protected $fillable = [
		'config_sub_jenis_produk_m_produk_id',
		'config_sub_jenis_produk_m_kategori_id',
		'config_sub_jenis_produk_created_by',
		'config_sub_jenis_produk_created_at',
		'config_sub_jenis_produk_updated_at',
		'config_sub_jenis_produk_deleted_at'
	];
}
