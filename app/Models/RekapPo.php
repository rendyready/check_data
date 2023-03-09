<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPo
 * 
 * @property int $rekap_po_id
 * @property string $rekap_po_code
 * @property Carbon $rekap_po_tgl
 * @property int $rekap_po_supplier_id
 * @property string $rekap_po_supplier_nama
 * @property string|null $rekap_po_supplier_telp
 * @property string|null $rekap_po_supplier_alamat
 * @property int $rekap_po_m_w_id
 * @property int $rekap_po_created_by
 * @property int|null $rekap_po_updated_by
 * @property int|null $rekap_po_deleted_by
 * @property Carbon $rekap_po_created_at
 * @property Carbon|null $rekap_po_updated_at
 * @property Carbon|null $rekap_po_deleted_at
 *
 * @package App\Models
 */
class RekapPo extends Model
{
	protected $table = 'rekap_po';
	protected $primaryKey = 'rekap_po_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_po_supplier_id' => 'int',
		'rekap_po_m_w_id' => 'int',
		'rekap_po_created_by' => 'int',
		'rekap_po_updated_by' => 'int',
		'rekap_po_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_po_tgl',
		'rekap_po_created_at',
		'rekap_po_updated_at',
		'rekap_po_deleted_at'
	];

	protected $fillable = [
		'rekap_po_code',
		'rekap_po_tgl',
		'rekap_po_supplier_id',
		'rekap_po_supplier_nama',
		'rekap_po_supplier_telp',
		'rekap_po_supplier_alamat',
		'rekap_po_m_w_id',
		'rekap_po_created_by',
		'rekap_po_updated_by',
		'rekap_po_deleted_by',
		'rekap_po_created_at',
		'rekap_po_updated_at',
		'rekap_po_deleted_at'
	];
}
