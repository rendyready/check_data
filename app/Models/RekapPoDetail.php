<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPoDetail
 * 
 * @property int $rekap_po_detal_id
 * @property string $rekap_po_detal_rekap_po_code
 * @property int $rekap_po_detail_m_produk_id
 * @property string $rekap_po_detail_m_produk_code
 * @property string $rekap_po_detail_m_produk_nama
 * @property float $rekap_po_detail_qty
 * @property string|null $rekap_po_detail_satuan
 * @property string $rekap_po_detail_catatan
 * @property int $rekap_po_detail_created_by
 * @property int|null $rekap_po_detail_updated_by
 * @property int|null $rekap_po_detail_deleted_by
 * @property Carbon $rekap_po_detail_created_at
 * @property Carbon|null $rekap_po_detail_updated_at
 * @property Carbon|null $rekap_po_detail_deleted_at
 *
 * @package App\Models
 */
class RekapPoDetail extends Model
{
	protected $table = 'rekap_po_detail';
	protected $primaryKey = 'rekap_po_detal_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_po_detail_m_produk_id' => 'int',
		'rekap_po_detail_qty' => 'float',
		'rekap_po_detail_created_by' => 'int',
		'rekap_po_detail_updated_by' => 'int',
		'rekap_po_detail_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_po_detail_created_at',
		'rekap_po_detail_updated_at',
		'rekap_po_detail_deleted_at'
	];

	protected $fillable = [
		'rekap_po_detal_rekap_po_code',
		'rekap_po_detail_m_produk_id',
		'rekap_po_detail_m_produk_code',
		'rekap_po_detail_m_produk_nama',
		'rekap_po_detail_qty',
		'rekap_po_detail_satuan',
		'rekap_po_detail_catatan',
		'rekap_po_detail_created_by',
		'rekap_po_detail_updated_by',
		'rekap_po_detail_deleted_by',
		'rekap_po_detail_created_at',
		'rekap_po_detail_updated_at',
		'rekap_po_detail_deleted_at'
	];
}
