<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTfGudang
 * 
 * @property int $id
 * @property int $rekap_tf_gudang_id
 * @property string $rekap_tf_gudang_code
 * @property string $rekap_tf_gudang_asal_code
 * @property string $rekap_tf_gudang_tujuan_code
 * @property int $rekap_tf_gudang_m_w_id
 * @property Carbon $rekap_tf_gudang_tgl_keluar
 * @property Carbon|null $rekap_tf_gudang_tgl_terima
 * @property string $rekap_tf_gudang_m_produk_code
 * @property string $rekap_tf_gudang_m_produk_nama
 * @property float $rekap_tf_gudang_qty_keluar
 * @property string|null $rekap_tf_gudang_satuan_keluar
 * @property float|null $rekap_tf_gudang_qty_terima
 * @property string|null $rekap_tf_gudang_satuan_terima
 * @property float $rekap_tf_gudang_hpp
 * @property float $rekap_tf_gudang_sub_total
 * @property int $rekap_tf_gudang_created_by
 * @property int|null $rekap_tf_gudang_updated_by
 * @property int|null $rekap_tf_gudang_deleted_by
 * @property Carbon $rekap_tf_gudang_created_at
 * @property Carbon|null $rekap_tf_gudang_updated_at
 * @property Carbon|null $rekap_tf_gudang_deleted_at
 *
 * @package App\Models
 */
class RekapTfGudang extends Model
{
	protected $table = 'rekap_tf_gudang';
	public $timestamps = false;

	protected $casts = [
		'rekap_tf_gudang_id' => 'int',
		'rekap_tf_gudang_m_w_id' => 'int',
		'rekap_tf_gudang_qty_keluar' => 'float',
		'rekap_tf_gudang_qty_terima' => 'float',
		'rekap_tf_gudang_hpp' => 'float',
		'rekap_tf_gudang_sub_total' => 'float',
		'rekap_tf_gudang_created_by' => 'int',
		'rekap_tf_gudang_updated_by' => 'int',
		'rekap_tf_gudang_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_tf_gudang_tgl_keluar',
		'rekap_tf_gudang_tgl_terima',
		'rekap_tf_gudang_created_at',
		'rekap_tf_gudang_updated_at',
		'rekap_tf_gudang_deleted_at'
	];

	protected $fillable = [
		'rekap_tf_gudang_id',
		'rekap_tf_gudang_code',
		'rekap_tf_gudang_asal_code',
		'rekap_tf_gudang_tujuan_code',
		'rekap_tf_gudang_m_w_id',
		'rekap_tf_gudang_tgl_keluar',
		'rekap_tf_gudang_tgl_terima',
		'rekap_tf_gudang_m_produk_code',
		'rekap_tf_gudang_m_produk_nama',
		'rekap_tf_gudang_qty_keluar',
		'rekap_tf_gudang_satuan_keluar',
		'rekap_tf_gudang_qty_terima',
		'rekap_tf_gudang_satuan_terima',
		'rekap_tf_gudang_hpp',
		'rekap_tf_gudang_sub_total',
		'rekap_tf_gudang_created_by',
		'rekap_tf_gudang_updated_by',
		'rekap_tf_gudang_deleted_by',
		'rekap_tf_gudang_created_at',
		'rekap_tf_gudang_updated_at',
		'rekap_tf_gudang_deleted_at'
	];
}
