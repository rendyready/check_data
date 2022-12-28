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
 * @property int $r_h_m_id
 * @property int|null $r_h_m_sync_id
 * @property int $r_h_m_rekap_modal_id
 * @property Carbon $r_h_m_tanggal
 * @property time without time zone $r_h_m_jam
 * @property string $r_h_m_nota_code
 * @property string $r_h_m_bigboss
 * @property int $r_h_m_m_produk_id
 * @property int $r_h_m_qty
 * @property float $r_h_m_price
 * @property float $r_h_m_nominal
 * @property float $r_h_m_nominal_pajak
 * @property float $r_h_m_nominal_sc
 * @property float $r_h_m_nominal_sharing_profit
 * @property string $r_h_m_keterangan
 * @property int $r_h_m_m_w_id
 * @property int $r_h_m_m_area_id
 * @property string $r_h_m_status_sync
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
	protected $primaryKey = 'r_h_m_id';
	public $timestamps = false;

	protected $casts = [
		'r_h_m_sync_id' => 'int',
		'r_h_m_rekap_modal_id' => 'int',
		'r_h_m_jam' => 'time without time zone',
		'r_h_m_m_produk_id' => 'int',
		'r_h_m_qty' => 'int',
		'r_h_m_price' => 'float',
		'r_h_m_nominal' => 'float',
		'r_h_m_nominal_pajak' => 'float',
		'r_h_m_nominal_sc' => 'float',
		'r_h_m_nominal_sharing_profit' => 'float',
		'r_h_m_m_w_id' => 'int',
		'r_h_m_m_area_id' => 'int',
		'r_h_m_created_by' => 'int',
		'r_h_m_updated_by' => 'int',
		'r_h_m_deleted_by' => 'int'
	];

	protected $dates = [
		'r_h_m_tanggal',
		'r_h_m_created_at',
		'r_h_m_updated_at',
		'r_h_m_deleted_at'
	];

	protected $fillable = [
		'r_h_m_sync_id',
		'r_h_m_rekap_modal_id',
		'r_h_m_tmp_transaction_id',
		'r_h_m_tanggal',
		'r_h_m_jam',
		'r_h_m_nota_code',
		'r_h_m_bigboss',
		'r_h_m_m_produk_id',
		'r_h_m_qty',
		'r_h_m_price',
		'r_h_m_nominal',
		'r_h_m_nominal_pajak',
		'r_h_m_nominal_sc',
		'r_h_m_nominal_sharing_profit',
		'r_h_m_keterangan',
		'r_h_m_m_w_id',
		'r_h_m_m_area_id',
		'r_h_m_status_sync',
		'r_h_m_created_by',
		'r_h_m_updated_by',
		'r_h_m_deleted_by',
		'r_h_m_created_at',
		'r_h_m_updated_at',
		'r_h_m_deleted_at'
	];
}
