<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MStok
 * 
 * @property int $id
 * @property int $m_stok_id
 * @property string $m_stok_m_produk_code
 * @property string $m_stok_produk_nama
 * @property string $m_stok_gudang_code
 * @property string $m_stok_waroeng
 * @property int|null $m_stok_satuan_id
 * @property string|null $m_stok_satuan
 * @property float $m_stok_awal
 * @property float $m_stok_masuk
 * @property float $m_stok_keluar
 * @property float $m_stok_saldo
 * @property float $m_stok_hpp
 * @property float $m_stok_rusak
 * @property float $m_stok_lelang
 * @property string $m_stok_isi
 * @property float $m_stok_konversi
 * @property int $m_stok_created_by
 * @property int|null $m_stok_updated_by
 * @property int|null $m_stok_deleted_by
 * @property Carbon $m_stok_created_at
 * @property Carbon|null $m_stok_updated_at
 * @property Carbon|null $m_stok_deleted_at
 *
 * @package App\Models
 */
class MStok extends Model
{
	protected $table = 'm_stok';
	public $timestamps = false;

	protected $casts = [
		'm_stok_id' => 'int',
		'm_stok_satuan_id' => 'int',
		'm_stok_awal' => 'float',
		'm_stok_masuk' => 'float',
		'm_stok_keluar' => 'float',
		'm_stok_saldo' => 'float',
		'm_stok_hpp' => 'float',
		'm_stok_rusak' => 'float',
		'm_stok_lelang' => 'float',
		'm_stok_konversi' => 'float',
		'm_stok_created_by' => 'int',
		'm_stok_updated_by' => 'int',
		'm_stok_deleted_by' => 'int'
	];

	protected $dates = [
		'm_stok_created_at',
		'm_stok_updated_at',
		'm_stok_deleted_at'
	];

	protected $fillable = [
		'm_stok_id',
		'm_stok_m_produk_code',
		'm_stok_produk_nama',
		'm_stok_gudang_code',
		'm_stok_waroeng',
		'm_stok_satuan_id',
		'm_stok_satuan',
		'm_stok_awal',
		'm_stok_masuk',
		'm_stok_keluar',
		'm_stok_saldo',
		'm_stok_hpp',
		'm_stok_rusak',
		'm_stok_lelang',
		'm_stok_isi',
		'm_stok_konversi',
		'm_stok_created_by',
		'm_stok_updated_by',
		'm_stok_deleted_by',
		'm_stok_created_at',
		'm_stok_updated_at',
		'm_stok_deleted_at'
	];
}
