<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapHapusMenu
 * 
 * @property int $id
 * @property string $r_h_m_id
 * @property string $r_h_m_rekap_modal_id
 * @property Carbon $r_h_m_tanggal
 * @property time without time zone $r_h_m_jam
 * @property string $r_h_m_nota_code
 * @property string $r_h_m_bigboss
 * @property int $r_h_m_m_produk_id
 * @property string|null $r_h_m_m_produk_code
 * @property string|null $r_h_m_m_produk_nama
 * @property int $r_h_m_qty
 * @property float $r_h_m_reguler_price
 * @property float $r_h_m_price
 * @property float $r_h_m_nominal
 * @property float $r_h_m_nominal_pajak
 * @property float $r_h_m_nominal_sc
 * @property float $r_h_m_nominal_sharing_profit_in
 * @property float $r_h_m_nominal_sharing_profit_out
 * @property string $r_h_m_keterangan
 * @property int $r_h_m_m_w_id
 * @property string|null $r_h_m_m_w_code
 * @property string|null $r_h_m_m_w_nama
 * @property int $r_h_m_m_area_id
 * @property string|null $r_h_m_m_area_code
 * @property string|null $r_h_m_m_area_nama
 * @property string $r_h_m_status_sync
 * @property int|null $r_h_m_approved_by
 * @property int $r_h_m_created_by
 * @property int|null $r_h_m_updated_by
 * @property int|null $r_h_m_deleted_by
 * @property Carbon $r_h_m_created_at
 * @property Carbon|null $r_h_m_updated_at
 * @property Carbon|null $r_h_m_deleted_at
 *
 * @package App\Models
 */
class RekapHapusMenu extends Model
{
	protected $table = 'rekap_hapus_menu';
	public $timestamps = false;

	protected $casts = [
		'r_h_m_tanggal' => 'datetime',
		'r_h_m_jam' => 'time without time zone',
		'r_h_m_m_produk_id' => 'int',
		'r_h_m_qty' => 'int',
		'r_h_m_reguler_price' => 'float',
		'r_h_m_price' => 'float',
		'r_h_m_nominal' => 'float',
		'r_h_m_nominal_pajak' => 'float',
		'r_h_m_nominal_sc' => 'float',
		'r_h_m_nominal_sharing_profit_in' => 'float',
		'r_h_m_nominal_sharing_profit_out' => 'float',
		'r_h_m_m_w_id' => 'int',
		'r_h_m_m_area_id' => 'int',
		'r_h_m_approved_by' => 'int',
		'r_h_m_created_by' => 'int',
		'r_h_m_updated_by' => 'int',
		'r_h_m_deleted_by' => 'int',
		'r_h_m_created_at' => 'datetime',
		'r_h_m_updated_at' => 'datetime',
		'r_h_m_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'r_h_m_id',
		'r_h_m_rekap_modal_id',
		'r_h_m_tanggal',
		'r_h_m_jam',
		'r_h_m_nota_code',
		'r_h_m_bigboss',
		'r_h_m_m_produk_id',
		'r_h_m_m_produk_code',
		'r_h_m_m_produk_nama',
		'r_h_m_qty',
		'r_h_m_reguler_price',
		'r_h_m_price',
		'r_h_m_nominal',
		'r_h_m_nominal_pajak',
		'r_h_m_nominal_sc',
		'r_h_m_nominal_sharing_profit_in',
		'r_h_m_nominal_sharing_profit_out',
		'r_h_m_keterangan',
		'r_h_m_m_w_id',
		'r_h_m_m_w_code',
		'r_h_m_m_w_nama',
		'r_h_m_m_area_id',
		'r_h_m_m_area_code',
		'r_h_m_m_area_nama',
		'r_h_m_status_sync',
		'r_h_m_approved_by',
		'r_h_m_created_by',
		'r_h_m_updated_by',
		'r_h_m_deleted_by',
		'r_h_m_created_at',
		'r_h_m_updated_at',
		'r_h_m_deleted_at'
	];
}