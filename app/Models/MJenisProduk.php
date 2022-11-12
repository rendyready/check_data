<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJenisProduk
 * 
 * @property int $m_jenis_produk_id
 * @property string $m_jenis_produk_nama
 * @property string $m_jenis_produk_urut
 * @property string|null $m_jenis_produk_odcr55
 * @property int $m_jenis_produk_created_by
 * @property Carbon $m_jenis_produk_created_at
 * @property int|null $m_jenis_produk_updated_by
 * @property Carbon|null $m_jenis_produk_updated_at
 * @property Carbon|null $m_jenis_produk_deleted_at
 *
 * @package App\Models
 */
class MJenisProduk extends Model
{
	protected $table = 'm_jenis_produk';
	protected $primaryKey = 'm_jenis_produk_id';
	public $timestamps = false;

	protected $casts = [
		'm_jenis_produk_created_by' => 'int',
		'm_jenis_produk_updated_by' => 'int'
	];

	protected $dates = [
		'm_jenis_produk_created_at',
		'm_jenis_produk_updated_at',
		'm_jenis_produk_deleted_at'
	];

	protected $fillable = [
		'm_jenis_produk_nama',
		'm_jenis_produk_urut',
		'm_jenis_produk_odcr55',
		'm_jenis_produk_created_by',
		'm_jenis_produk_created_at',
		'm_jenis_produk_updated_by',
		'm_jenis_produk_updated_at',
		'm_jenis_produk_deleted_at'
	];
}
