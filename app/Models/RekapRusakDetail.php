<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapRusakDetail
 * 
 * @property int $rekap_rusak_id
 * @property string $rekap_rusak_detail_rekap_rusak_code
 * @property int $rekap_rusak_detail_m_produk_id
 * @property int $rekap_rusak_detail_gudang_id
 * @property string $rekap_rusak_detail_m_produk_code
 * @property string $rekap_rusak_detail_m_produk_nama
 * @property float $rekap_rusak_detail_qty
 * @property float $rekap_rusak_detail_hpp
 * @property float $rekap_rusak_detail_sub_total
 * @property string|null $rekap_rusak_detail_satuan
 * @property string $rekap_rusak_detail_catatan
 * @property int $rekap_rusak_detail_created_by
 * @property int|null $rekap_rusak_detail_updated_by
 * @property int|null $rekap_rusak_detail_deleted_by
 * @property Carbon $rekap_rusak_detail_created_at
 * @property Carbon|null $rekap_rusak_detail_updated_at
 * @property Carbon|null $rekap_rusak_detail_deleted_at
 *
 * @package App\Models
 */
class RekapRusakDetail extends Model
{
	protected $table = 'rekap_rusak_detail';
	protected $primaryKey = 'rekap_rusak_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_rusak_detail_m_produk_id' => 'int',
		'rekap_rusak_detail_gudang_id' => 'int',
		'rekap_rusak_detail_qty' => 'float',
		'rekap_rusak_detail_hpp' => 'float',
		'rekap_rusak_detail_sub_total' => 'float',
		'rekap_rusak_detail_created_by' => 'int',
		'rekap_rusak_detail_updated_by' => 'int',
		'rekap_rusak_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_rusak_detail_created_at',
		'rekap_rusak_detail_updated_at',
		'rekap_rusak_detail_deleted_at'
	];

	protected $fillable = [
		'rekap_rusak_detail_rekap_rusak_code',
		'rekap_rusak_detail_m_produk_id',
		'rekap_rusak_detail_gudang_id',
		'rekap_rusak_detail_m_produk_code',
		'rekap_rusak_detail_m_produk_nama',
		'rekap_rusak_detail_qty',
		'rekap_rusak_detail_hpp',
		'rekap_rusak_detail_sub_total',
		'rekap_rusak_detail_satuan',
		'rekap_rusak_detail_catatan',
		'rekap_rusak_detail_created_by',
		'rekap_rusak_detail_updated_by',
		'rekap_rusak_detail_deleted_by',
		'rekap_rusak_detail_created_at',
		'rekap_rusak_detail_updated_at',
		'rekap_rusak_detail_deleted_at'
	];
}
