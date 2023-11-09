<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapSoDetail
 * 
 * @property int $id
 * @property string $rekap_so_detail_id
 * @property string $rekap_so_detail_m_gudang_code
 * @property string $rekap_so_detail_m_produk_code
 * @property string $rekap_so_detail_m_produk_nama
 * @property string $rekap_so_detail_qty
 * @property string $rekap_so_detail_satuan
 * @property string $rekap_so_detail_qty_riil
 * @property int $rekap_so_detail_created_by
 * @property int|null $rekap_so_detail_updated_by
 * @property int|null $rekap_so_detail_deleted_by
 * @property Carbon $rekap_so_detail_created_at
 * @property Carbon|null $rekap_so_detail_updated_at
 * @property Carbon|null $rekap_so_detail_deleted_at
 *
 * @package App\Models
 */
class RekapSoDetail extends Model
{
	protected $table = 'rekap_so_detail';
	public $timestamps = false;

	protected $casts = [
		'rekap_so_detail_created_by' => 'int',
		'rekap_so_detail_updated_by' => 'int',
		'rekap_so_detail_deleted_by' => 'int',
		'rekap_so_detail_created_at' => 'datetime',
		'rekap_so_detail_updated_at' => 'datetime',
		'rekap_so_detail_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rekap_so_detail_id',
		'rekap_so_detail_m_gudang_code',
		'rekap_so_detail_m_produk_code',
		'rekap_so_detail_m_produk_nama',
		'rekap_so_detail_qty',
		'rekap_so_detail_satuan',
		'rekap_so_detail_qty_riil',
		'rekap_so_detail_created_by',
		'rekap_so_detail_updated_by',
		'rekap_so_detail_deleted_by',
		'rekap_so_detail_created_at',
		'rekap_so_detail_updated_at',
		'rekap_so_detail_deleted_at'
	];
}
