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
 * @property int $m_klasifikasi_produk_id
 * @property string $m_klasifikasi_produk_nama
 * @property int $m_klasifikasi_produk_created_by
 * @property int|null $m_klasifikasi_produk_updated_by
 * @property Carbon $m_klasifikasi_produk_created_at
 * @property Carbon|null $m_klasifikasi_produk_updated_at
 * @property Carbon|null $m_klasifikasi_produk_deleted_at
 *
 * @package App\Models
 */
class MKlasifikasiProduk extends Model
{
	protected $table = 'm_klasifikasi_produk';
	protected $primaryKey = 'm_klasifikasi_produk_id';
	public $timestamps = false;

	protected $casts = [
		'm_klasifikasi_produk_created_by' => 'int',
		'm_klasifikasi_produk_updated_by' => 'int'
	];

	protected $dates = [
		'm_klasifikasi_produk_created_at',
		'm_klasifikasi_produk_updated_at',
		'm_klasifikasi_produk_deleted_at'
	];

	protected $fillable = [
		'm_klasifikasi_produk_nama',
		'm_klasifikasi_produk_created_by',
		'm_klasifikasi_produk_updated_by',
		'm_klasifikasi_produk_created_at',
		'm_klasifikasi_produk_updated_at',
		'm_klasifikasi_produk_deleted_at'
	];
}
