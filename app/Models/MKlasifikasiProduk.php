<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MKlasifikasiProduk
 * 
 * @property int $id
 * @property int $m_klasifikasi_produk_id
 * @property string $m_klasifikasi_produk_nama
 * @property string $m_klasifikasi_produk_prefix
 * @property int $m_klasifikasi_produk_last_id
 * @property int $m_klasifikasi_produk_created_by
 * @property int|null $m_klasifikasi_produk_updated_by
 * @property int|null $m_klasifikasi_produk_deleted_by
 * @property Carbon $m_klasifikasi_produk_created_at
 * @property Carbon|null $m_klasifikasi_produk_updated_at
 * @property Carbon|null $m_klasifikasi_produk_deleted_at
 * @property string $m_klasifikasi_produk_status_sync
 *
 * @package App\Models
 */
class MKlasifikasiProduk extends Model
{
	protected $table = 'm_klasifikasi_produk';
	public $timestamps = false;

	protected $casts = [
		'm_klasifikasi_produk_id' => 'int',
		'm_klasifikasi_produk_last_id' => 'int',
		'm_klasifikasi_produk_created_by' => 'int',
		'm_klasifikasi_produk_updated_by' => 'int',
		'm_klasifikasi_produk_deleted_by' => 'int',
		'm_klasifikasi_produk_created_at' => 'datetime',
		'm_klasifikasi_produk_updated_at' => 'datetime',
		'm_klasifikasi_produk_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_klasifikasi_produk_id',
		'm_klasifikasi_produk_nama',
		'm_klasifikasi_produk_prefix',
		'm_klasifikasi_produk_last_id',
		'm_klasifikasi_produk_created_by',
		'm_klasifikasi_produk_updated_by',
		'm_klasifikasi_produk_deleted_by',
		'm_klasifikasi_produk_created_at',
		'm_klasifikasi_produk_updated_at',
		'm_klasifikasi_produk_deleted_at',
		'm_klasifikasi_produk_status_sync'
	];
}
