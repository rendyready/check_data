<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapLostBill
 * 
 * @property int $r_l_b_id
 * @property int|null $r_l_b_sync_id
 * @property int $r_l_b_rekap_modal_id
 * @property Carbon $r_l_b_tanggal
 * @property time without time zone $r_l_b_jam
 * @property string $r_l_b_nota_code
 * @property string $r_l_b_bigboss
 * @property float $r_l_b_nominal
 * @property float $r_l_b_nominal_pajak
 * @property float $r_l_b_nominal_sc
 * @property float $r_l_b_nominal_sharing_profit_in
 * @property float $r_l_b_nominal_sharing_profit_out
 * @property string $r_l_b_keterangan
 * @property int $r_l_b_m_w_id
 * @property string|null $r_l_b_m_w_nama
 * @property int $r_l_b_m_area_id
 * @property string|null $r_l_b_m_area_nama
 * @property string $r_l_b_status_sync
 * @property int|null $r_l_b_approved_by
 * @property int $r_l_b_created_by
 * @property int|null $r_l_b_updated_by
 * @property int|null $r_l_b_deleted_by
 * @property Carbon $r_l_b_created_at
 * @property Carbon|null $r_l_b_updated_at
 * @property Carbon|null $r_l_b_deleted_at
 *
 * @package App\Models
 */
class RekapLostBill extends Model
{
	protected $table = 'rekap_lost_bill';
	protected $primaryKey = 'r_l_b_id';
	public $timestamps = false;

	protected $casts = [
		'r_l_b_sync_id' => 'int',
		'r_l_b_rekap_modal_id' => 'int',
		'r_l_b_jam' => 'time without time zone',
		'r_l_b_nominal' => 'float',
		'r_l_b_nominal_pajak' => 'float',
		'r_l_b_nominal_sc' => 'float',
		'r_l_b_nominal_sharing_profit_in' => 'float',
		'r_l_b_nominal_sharing_profit_out' => 'float',
		'r_l_b_m_w_id' => 'int',
		'r_l_b_m_area_id' => 'int',
		'r_l_b_approved_by' => 'int',
		'r_l_b_created_by' => 'int',
		'r_l_b_updated_by' => 'int',
		'r_l_b_deleted_by' => 'int'
	];

	protected $dates = [
		'r_l_b_tanggal',
		'r_l_b_created_at',
		'r_l_b_updated_at',
		'r_l_b_deleted_at'
	];

	protected $fillable = [
		'r_l_b_sync_id',
		'r_l_b_rekap_modal_id',
		'r_l_b_tanggal',
		'r_l_b_jam',
		'r_l_b_nota_code',
		'r_l_b_bigboss',
		'r_l_b_nominal',
		'r_l_b_nominal_pajak',
		'r_l_b_nominal_sc',
		'r_l_b_nominal_sharing_profit_in',
		'r_l_b_nominal_sharing_profit_out',
		'r_l_b_keterangan',
		'r_l_b_m_w_id',
		'r_l_b_m_w_nama',
		'r_l_b_m_area_id',
		'r_l_b_m_area_nama',
		'r_l_b_status_sync',
		'r_l_b_approved_by',
		'r_l_b_created_by',
		'r_l_b_updated_by',
		'r_l_b_deleted_by',
		'r_l_b_created_at',
		'r_l_b_updated_at',
		'r_l_b_deleted_at'
	];
}
