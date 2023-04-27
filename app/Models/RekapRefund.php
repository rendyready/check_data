<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapRefund
 * 
 * @property int $id
 * @property string $r_r_id
 * @property string $r_r_rekap_modal_id
 * @property string $r_r_r_t_id
 * @property string $r_r_nota_code
 * @property string $r_r_bigboss
 * @property Carbon $r_r_tanggal
 * @property time without time zone $r_r_jam
 * @property int $r_r_m_area_id
 * @property string|null $r_r_m_area_code
 * @property string|null $r_r_m_area_nama
 * @property int $r_r_m_w_id
 * @property string|null $r_r_m_w_code
 * @property string|null $r_r_m_w_nama
 * @property float $r_r_nominal_refund
 * @property float $r_r_nominal_refund_pajak
 * @property float $r_r_nominal_refund_sc
 * @property float $r_r_nominal_pembulatan_refund
 * @property float $r_r_nominal_free_kembalian_refund
 * @property float $r_r_nominal_refund_total
 * @property float $r_r_tax_percent
 * @property float $r_r_sc_percent
 * @property string|null $r_r_keterangan
 * @property string $r_r_status_sync
 * @property int|null $r_r_approved_by
 * @property int $r_r_created_by
 * @property int|null $r_r_updated_by
 * @property int|null $r_r_deleted_by
 * @property Carbon $r_r_created_at
 * @property Carbon|null $r_r_updated_at
 * @property Carbon|null $r_r_deleted_at
 *
 * @package App\Models
 */
class RekapRefund extends Model
{
	protected $table = 'rekap_refund';
	public $timestamps = false;

	protected $casts = [
		'r_r_tanggal' => 'datetime',
		'r_r_jam' => 'time without time zone',
		'r_r_m_area_id' => 'int',
		'r_r_m_w_id' => 'int',
		'r_r_nominal_refund' => 'float',
		'r_r_nominal_refund_pajak' => 'float',
		'r_r_nominal_refund_sc' => 'float',
		'r_r_nominal_pembulatan_refund' => 'float',
		'r_r_nominal_free_kembalian_refund' => 'float',
		'r_r_nominal_refund_total' => 'float',
		'r_r_tax_percent' => 'float',
		'r_r_sc_percent' => 'float',
		'r_r_approved_by' => 'int',
		'r_r_created_by' => 'int',
		'r_r_updated_by' => 'int',
		'r_r_deleted_by' => 'int',
		'r_r_created_at' => 'datetime',
		'r_r_updated_at' => 'datetime',
		'r_r_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'r_r_id',
		'r_r_rekap_modal_id',
		'r_r_r_t_id',
		'r_r_nota_code',
		'r_r_bigboss',
		'r_r_tanggal',
		'r_r_jam',
		'r_r_m_area_id',
		'r_r_m_area_code',
		'r_r_m_area_nama',
		'r_r_m_w_id',
		'r_r_m_w_code',
		'r_r_m_w_nama',
		'r_r_nominal_refund',
		'r_r_nominal_refund_pajak',
		'r_r_nominal_refund_sc',
		'r_r_nominal_pembulatan_refund',
		'r_r_nominal_free_kembalian_refund',
		'r_r_nominal_refund_total',
		'r_r_tax_percent',
		'r_r_sc_percent',
		'r_r_keterangan',
		'r_r_status_sync',
		'r_r_approved_by',
		'r_r_created_by',
		'r_r_updated_by',
		'r_r_deleted_by',
		'r_r_created_at',
		'r_r_updated_at',
		'r_r_deleted_at'
	];
}
