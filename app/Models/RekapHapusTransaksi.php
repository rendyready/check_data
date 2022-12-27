<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapHapusTransaksi
 * 
 * @property int $r_h_t_id
 * @property int|null $r_h_t_sync_id
 * @property int $r_h_t_rekap_modal_id
 * @property string $r_h_t_tmp_transaction_id
 * @property string $r_h_t_nota_code
 * @property Carbon $r_h_t_tanggal
 * @property time without time zone $r_h_t_jam
 * @property string $r_h_t_bigboss
 * @property int $r_h_t_m_area_id
 * @property int $r_h_t_m_w_id
 * @property float $r_h_t_nominal
 * @property float $r_h_t_nominal_pajak
 * @property float $r_h_t_nominal_sc
 * @property float $r_h_t_nominal_sharing_profit
 * @property int $r_h_t_m_t_t_id
 * @property string $r_h_t_status_sync
 * @property int $r_h_t_created_by
 * @property int|null $r_h_t_updated_by
 * @property int|null $r_h_t_deleted_by
 * @property Carbon $r_h_t_created_at
 * @property Carbon|null $r_h_t_updated_at
 * @property Carbon|null $r_h_t_deleted_at
 *
 * @package App\Models
 */
class RekapHapusTransaksi extends Model
{
	protected $table = 'rekap_hapus_transaksi';
	protected $primaryKey = 'r_h_t_id';
	public $timestamps = false;

	protected $casts = [
		'r_h_t_sync_id' => 'int',
		'r_h_t_rekap_modal_id' => 'int',
		'r_h_t_jam' => 'time without time zone',
		'r_h_t_m_area_id' => 'int',
		'r_h_t_m_w_id' => 'int',
		'r_h_t_nominal' => 'float',
		'r_h_t_nominal_pajak' => 'float',
		'r_h_t_nominal_sc' => 'float',
		'r_h_t_nominal_sharing_profit' => 'float',
		'r_h_t_m_t_t_id' => 'int',
		'r_h_t_created_by' => 'int',
		'r_h_t_updated_by' => 'int',
		'r_h_t_deleted_by' => 'int'
	];

	protected $dates = [
		'r_h_t_tanggal',
		'r_h_t_created_at',
		'r_h_t_updated_at',
		'r_h_t_deleted_at'
	];

	protected $fillable = [
		'r_h_t_sync_id',
		'r_h_t_rekap_modal_id',
		'r_h_t_tmp_transaction_id',
		'r_h_t_nota_code',
		'r_h_t_tanggal',
		'r_h_t_jam',
		'r_h_t_bigboss',
		'r_h_t_m_area_id',
		'r_h_t_m_w_id',
		'r_h_t_nominal',
		'r_h_t_nominal_pajak',
		'r_h_t_nominal_sc',
		'r_h_t_nominal_sharing_profit',
		'r_h_t_m_t_t_id',
		'r_h_t_status_sync',
		'r_h_t_created_by',
		'r_h_t_updated_by',
		'r_h_t_deleted_by',
		'r_h_t_created_at',
		'r_h_t_updated_at',
		'r_h_t_deleted_at'
	];
}
