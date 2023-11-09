<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapBeliDetail
 * 
 * @property int $id
 * @property int $rekap_beli_detail_id
 * @property string $rekap_beli_detail_rekap_beli_code
 * @property string $rekap_beli_detail_m_produk_code
 * @property string $rekap_beli_detail_m_produk_nama
 * @property string $rekap_beli_detail_catatan
 * @property float $rekap_beli_detail_qty
 * @property float $rekap_beli_detail_harga
 * @property float|null $rekap_beli_detail_disc
 * @property float|null $rekap_beli_detail_discrp
 * @property float $rekap_beli_detail_subtot
 * @property int $rekap_beli_detail_m_w_id
 * @property string|null $rekap_beli_detail_terima_qty
 * @property int|null $rekap_beli_detail_satuan_id
 * @property string|null $rekap_beli_detail_satuan_terima
 * @property int $rekap_beli_detail_created_by
 * @property int|null $rekap_beli_detail_updated_by
 * @property int|null $rekap_beli_detail_deleted_by
 * @property Carbon $rekap_beli_detail_created_at
 * @property Carbon|null $rekap_beli_detail_updated_at
 * @property Carbon|null $rekap_beli_detail_deleted_at
 *
 * @package App\Models
 */
class RekapBeliDetail extends Model
{
	protected $table = 'rekap_beli_detail';
	public $timestamps = false;

	protected $casts = [
		'rekap_beli_detail_id' => 'int',
		'rekap_beli_detail_qty' => 'float',
		'rekap_beli_detail_harga' => 'float',
		'rekap_beli_detail_disc' => 'float',
		'rekap_beli_detail_discrp' => 'float',
		'rekap_beli_detail_subtot' => 'float',
		'rekap_beli_detail_m_w_id' => 'int',
		'rekap_beli_detail_satuan_id' => 'int',
		'rekap_beli_detail_created_by' => 'int',
		'rekap_beli_detail_updated_by' => 'int',
		'rekap_beli_detail_deleted_by' => 'int',
		'rekap_beli_detail_created_at' => 'datetime',
		'rekap_beli_detail_updated_at' => 'datetime',
		'rekap_beli_detail_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rekap_beli_detail_id',
		'rekap_beli_detail_rekap_beli_code',
		'rekap_beli_detail_m_produk_code',
		'rekap_beli_detail_m_produk_nama',
		'rekap_beli_detail_catatan',
		'rekap_beli_detail_qty',
		'rekap_beli_detail_harga',
		'rekap_beli_detail_disc',
		'rekap_beli_detail_discrp',
		'rekap_beli_detail_subtot',
		'rekap_beli_detail_m_w_id',
		'rekap_beli_detail_terima_qty',
		'rekap_beli_detail_satuan_id',
		'rekap_beli_detail_satuan_terima',
		'rekap_beli_detail_created_by',
		'rekap_beli_detail_updated_by',
		'rekap_beli_detail_deleted_by',
		'rekap_beli_detail_created_at',
		'rekap_beli_detail_updated_at',
		'rekap_beli_detail_deleted_at'
	];
}
