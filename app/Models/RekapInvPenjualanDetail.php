<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapInvPenjualanDetail
 * 
 * @property int $rekap_inv_penjualan_detail_id
 * @property string $rekap_inv_penjualan_detail_rekap_inv_penjualan_code
 * @property int $rekap_inv_penjualan_detail_m_produk_id
 * @property string $rekap_inv_penjualan_detail_m_produk_code
 * @property string $rekap_inv_penjualan_detail_m_produk_nama
 * @property float $rekap_inv_penjualan_detail_qty
 * @property string|null $rekap_inv_penjualan_detail_satuan
 * @property float $rekap_inv_penjualan_detail_harga
 * @property float|null $rekap_inv_penjualan_detail_disc
 * @property float|null $rekap_inv_penjualan_detail_discrp
 * @property float $rekap_inv_penjualan_detail_subtot
 * @property string $rekap_inv_penjualan_detail_catatan
 * @property int $rekap_inv_penjualan_detail_created_by
 * @property int|null $rekap_inv_penjualan_detail_updated_by
 * @property int|null $rekap_inv_penjualan_detail_deleted_by
 * @property Carbon $rekap_inv_penjualan_detail_created_at
 * @property Carbon|null $rekap_inv_penjualan_detail_updated_at
 * @property Carbon|null $rekap_inv_penjualan_detail_deleted_at
 *
 * @package App\Models
 */
class RekapInvPenjualanDetail extends Model
{
	protected $table = 'rekap_inv_penjualan_detail';
	protected $primaryKey = 'rekap_inv_penjualan_detail_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_inv_penjualan_detail_m_produk_id' => 'int',
		'rekap_inv_penjualan_detail_qty' => 'float',
		'rekap_inv_penjualan_detail_harga' => 'float',
		'rekap_inv_penjualan_detail_disc' => 'float',
		'rekap_inv_penjualan_detail_discrp' => 'float',
		'rekap_inv_penjualan_detail_subtot' => 'float',
		'rekap_inv_penjualan_detail_created_by' => 'int',
		'rekap_inv_penjualan_detail_updated_by' => 'int',
		'rekap_inv_penjualan_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_inv_penjualan_detail_created_at',
		'rekap_inv_penjualan_detail_updated_at',
		'rekap_inv_penjualan_detail_deleted_at'
	];

	protected $fillable = [
		'rekap_inv_penjualan_detail_rekap_inv_penjualan_code',
		'rekap_inv_penjualan_detail_m_produk_id',
		'rekap_inv_penjualan_detail_m_produk_code',
		'rekap_inv_penjualan_detail_m_produk_nama',
		'rekap_inv_penjualan_detail_qty',
		'rekap_inv_penjualan_detail_satuan',
		'rekap_inv_penjualan_detail_harga',
		'rekap_inv_penjualan_detail_disc',
		'rekap_inv_penjualan_detail_discrp',
		'rekap_inv_penjualan_detail_subtot',
		'rekap_inv_penjualan_detail_catatan',
		'rekap_inv_penjualan_detail_created_by',
		'rekap_inv_penjualan_detail_updated_by',
		'rekap_inv_penjualan_detail_deleted_by',
		'rekap_inv_penjualan_detail_created_at',
		'rekap_inv_penjualan_detail_updated_at',
		'rekap_inv_penjualan_detail_deleted_at'
	];
}
