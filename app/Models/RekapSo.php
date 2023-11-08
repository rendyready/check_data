<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapSo
 * 
 * @property int $id
 * @property string $rekap_so_code
 * @property Carbon $rekap_so_tgl
 * @property string $rekap_so_m_gudang_code
 * @property int $rekap_so_m_klasifikasi_produk_id
 * @property string $rekap_so_m_w_code
 * @property string $rekap_so_m_w_nama
 * @property int $rekap_so_created_by
 * @property int|null $rekap_so_updated_by
 * @property int|null $rekap_so_deleted_by
 * @property Carbon $rekap_so_created_at
 * @property Carbon|null $rekap_so_updated_at
 * @property Carbon|null $rekap_so_deleted_at
 *
 * @package App\Models
 */
class RekapSo extends Model
{
	protected $table = 'rekap_so';
	public $timestamps = false;

	protected $casts = [
		'rekap_so_tgl' => 'datetime',
		'rekap_so_m_klasifikasi_produk_id' => 'int',
		'rekap_so_created_by' => 'int',
		'rekap_so_updated_by' => 'int',
		'rekap_so_deleted_by' => 'int',
		'rekap_so_created_at' => 'datetime',
		'rekap_so_updated_at' => 'datetime',
		'rekap_so_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rekap_so_code',
		'rekap_so_tgl',
		'rekap_so_m_gudang_code',
		'rekap_so_m_klasifikasi_produk_id',
		'rekap_so_m_w_code',
		'rekap_so_m_w_nama',
		'rekap_so_created_by',
		'rekap_so_updated_by',
		'rekap_so_deleted_by',
		'rekap_so_created_at',
		'rekap_so_updated_at',
		'rekap_so_deleted_at'
	];
}
