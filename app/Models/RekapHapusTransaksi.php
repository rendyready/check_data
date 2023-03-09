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
 * @property int $id
 * @property string $r_h_t_id
 * @property string $r_h_t_rekap_modal_id
 * @property string $r_h_t_nota_code
 * @property Carbon $r_h_t_tanggal
 * @property time without time zone $r_h_t_jam
 * @property string $r_h_t_bigboss
 * @property int $r_h_t_m_area_id
 * @property string|null $r_h_t_m_area_code
 * @property string|null $r_h_t_m_area_nama
 * @property int $r_h_t_m_w_id
 * @property string|null $r_h_t_m_w_code
 * @property string|null $r_h_t_m_w_nama
 * @property float $r_h_t_nominal
 * @property float $r_h_t_nominal_pajak
 * @property float $r_h_t_nominal_sc
 * @property float $r_h_t_nominal_sharing_profit_in
 * @property float $r_h_t_nominal_sharing_profit_out
 * @property int $r_h_t_m_t_t_id
 * @property string $r_h_t_status_sync
 * @property int|null $r_h_t_approved_by
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
	public $timestamps = false;

	protected $casts = [
		'r_h_t_jam' => 'time without time zone',
		'r_h_t_m_area_id' => 'int',
		'r_h_t_m_w_id' => 'int',
		'r_h_t_nominal' => 'float',
		'r_h_t_nominal_pajak' => 'float',
		'r_h_t_nominal_sc' => 'float',
		'r_h_t_nominal_sharing_profit_in' => 'float',
		'r_h_t_nominal_sharing_profit_out' => 'float',
		'r_h_t_m_t_t_id' => 'int',
		'r_h_t_approved_by' => 'int',
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
		'r_h_t_id',
		'r_h_t_rekap_modal_id',
		'r_h_t_nota_code',
		'r_h_t_tanggal',
		'r_h_t_jam',
		'r_h_t_bigboss',
		'r_h_t_m_area_id',
		'r_h_t_m_area_code',
		'r_h_t_m_area_nama',
		'r_h_t_m_w_id',
		'r_h_t_m_w_code',
		'r_h_t_m_w_nama',
		'r_h_t_nominal',
		'r_h_t_nominal_pajak',
		'r_h_t_nominal_sc',
		'r_h_t_nominal_sharing_profit_in',
		'r_h_t_nominal_sharing_profit_out',
		'r_h_t_m_t_t_id',
		'r_h_t_status_sync',
		'r_h_t_approved_by',
		'r_h_t_created_by',
		'r_h_t_updated_by',
		'r_h_t_deleted_by',
		'r_h_t_created_at',
		'r_h_t_updated_at',
		'r_h_t_deleted_at'
	];
}
