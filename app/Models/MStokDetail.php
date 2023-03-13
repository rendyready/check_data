<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MStokDetail
 * 
 * @property int $id
 * @property string $m_stok_detail_id
 * @property string $m_stok_detail_code
 * @property Carbon $m_stok_detail_tgl
 * @property string $m_stok_detail_m_produk_code
 * @property string $m_stok_detail_m_produk_nama
 * @property int $m_stok_detail_satuan_id
 * @property string $m_stok_detail_gudang_code
 * @property string|null $m_stok_detail_satuan
 * @property float|null $m_stok_detail_masuk
 * @property float|null $m_stok_detail_keluar
 * @property float $m_stok_detail_saldo
 * @property float|null $m_stok_detail_so
 * @property float $m_stok_detail_hpp
 * @property string $m_stok_detail_catatan
 * @property int $m_stok_detail_created_by
 * @property int|null $m_stok_detail_updated_by
 * @property int|null $m_stok_detail_deleted_by
 * @property Carbon $m_stok_detail_created_at
 * @property Carbon|null $m_stok_detail_updated_at
 * @property Carbon|null $m_stok_detail_deleted_at
 *
 * @package App\Models
 */
class MStokDetail extends Model
{
	protected $table = 'm_stok_detail';
	public $timestamps = false;

	protected $casts = [
		'm_stok_detail_satuan_id' => 'int',
		'm_stok_detail_masuk' => 'float',
		'm_stok_detail_keluar' => 'float',
		'm_stok_detail_saldo' => 'float',
		'm_stok_detail_so' => 'float',
		'm_stok_detail_hpp' => 'float',
		'm_stok_detail_created_by' => 'int',
		'm_stok_detail_updated_by' => 'int',
		'm_stok_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'm_stok_detail_tgl',
		'm_stok_detail_created_at',
		'm_stok_detail_updated_at',
		'm_stok_detail_deleted_at'
	];

	protected $fillable = [
		'm_stok_detail_id',
		'm_stok_detail_code',
		'm_stok_detail_tgl',
		'm_stok_detail_m_produk_code',
		'm_stok_detail_m_produk_nama',
		'm_stok_detail_satuan_id',
		'm_stok_detail_gudang_code',
		'm_stok_detail_satuan',
		'm_stok_detail_masuk',
		'm_stok_detail_keluar',
		'm_stok_detail_saldo',
		'm_stok_detail_so',
		'm_stok_detail_hpp',
		'm_stok_detail_catatan',
		'm_stok_detail_created_by',
		'm_stok_detail_updated_by',
		'm_stok_detail_deleted_by',
		'm_stok_detail_created_at',
		'm_stok_detail_updated_at',
		'm_stok_detail_deleted_at'
	];
}
