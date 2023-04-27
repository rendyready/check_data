<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MSubJenisProduk
 * 
 * @property int $id
 * @property int $m_sub_jenis_produk_id
 * @property string $m_sub_jenis_produk_nama
 * @property int $m_sub_jenis_produk_m_jenis_produk_id
 * @property int $m_sub_jenis_produk_created_by
 * @property int|null $m_sub_jenis_produk_updated_by
 * @property int|null $m_sub_jenis_produk_deleted_by
 * @property Carbon $m_sub_jenis_produk_created_at
 * @property Carbon|null $m_sub_jenis_produk_updated_at
 * @property Carbon|null $m_sub_jenis_produk_deleted_at
 * @property string $m_sub_jenis_produk_status_sync
 *
 * @package App\Models
 */
class MSubJenisProduk extends Model
{
	protected $table = 'm_sub_jenis_produk';
	public $timestamps = false;

	protected $casts = [
		'm_sub_jenis_produk_id' => 'int',
		'm_sub_jenis_produk_m_jenis_produk_id' => 'int',
		'm_sub_jenis_produk_created_by' => 'int',
		'm_sub_jenis_produk_updated_by' => 'int',
		'm_sub_jenis_produk_deleted_by' => 'int',
		'm_sub_jenis_produk_created_at' => 'datetime',
		'm_sub_jenis_produk_updated_at' => 'datetime',
		'm_sub_jenis_produk_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_sub_jenis_produk_id',
		'm_sub_jenis_produk_nama',
		'm_sub_jenis_produk_m_jenis_produk_id',
		'm_sub_jenis_produk_created_by',
		'm_sub_jenis_produk_updated_by',
		'm_sub_jenis_produk_deleted_by',
		'm_sub_jenis_produk_created_at',
		'm_sub_jenis_produk_updated_at',
		'm_sub_jenis_produk_deleted_at',
		'm_sub_jenis_produk_status_sync'
	];
}
