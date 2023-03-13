<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTransaksi
 * 
 * @property int $id
 * @property string $r_t_id
 * @property string $r_t_rekap_modal_id
 * @property string $r_t_nota_code
 * @property string $r_t_bigboss
 * @property string|null $r_t_member_id
 * @property Carbon $r_t_tanggal
 * @property time without time zone $r_t_jam
 * @property int $r_t_m_area_id
 * @property string|null $r_t_m_area_code
 * @property string|null $r_t_m_area_nama
 * @property int $r_t_m_w_id
 * @property string|null $r_t_m_w_code
 * @property string|null $r_t_m_w_nama
 * @property float $r_t_nominal
 * @property float $r_t_nominal_pajak
 * @property float $r_t_nominal_sc
 * @property float $r_t_nominal_sharing_profit_in
 * @property float $r_t_nominal_sharing_profit_out
 * @property float $r_t_nominal_diskon
 * @property float $r_t_nominal_voucher
 * @property float $r_t_nominal_pembulatan
 * @property float $r_t_nominal_tarik_tunai
 * @property float $r_t_nominal_total_bayar
 * @property float $r_t_nominal_total_uang
 * @property float $r_t_nominal_kembalian
 * @property float $r_t_nominal_free_kembalian
 * @property float $r_t_nominal_total_kembalian
 * @property float $r_t_tax_percent
 * @property float $r_t_sc_percent
 * @property int $r_t_m_t_t_id
 * @property string $r_t_status
 * @property string|null $r_t_catatan
 * @property string $r_t_status_sync
 * @property int $r_t_created_by
 * @property int|null $r_t_updated_by
 * @property int|null $r_t_deleted_by
 * @property Carbon $r_t_created_at
 * @property Carbon|null $r_t_updated_at
 * @property Carbon|null $r_t_deleted_at
 *
 * @package App\Models
 */
class RekapTransaksi extends Model
{
	protected $table = 'rekap_transaksi';
	public $timestamps = false;

	protected $casts = [
		'r_t_jam' => 'time without time zone',
		'r_t_m_area_id' => 'int',
		'r_t_m_w_id' => 'int',
		'r_t_nominal' => 'float',
		'r_t_nominal_pajak' => 'float',
		'r_t_nominal_sc' => 'float',
		'r_t_nominal_sharing_profit_in' => 'float',
		'r_t_nominal_sharing_profit_out' => 'float',
		'r_t_nominal_diskon' => 'float',
		'r_t_nominal_voucher' => 'float',
		'r_t_nominal_pembulatan' => 'float',
		'r_t_nominal_tarik_tunai' => 'float',
		'r_t_nominal_total_bayar' => 'float',
		'r_t_nominal_total_uang' => 'float',
		'r_t_nominal_kembalian' => 'float',
		'r_t_nominal_free_kembalian' => 'float',
		'r_t_nominal_total_kembalian' => 'float',
		'r_t_tax_percent' => 'float',
		'r_t_sc_percent' => 'float',
		'r_t_m_t_t_id' => 'int',
		'r_t_created_by' => 'int',
		'r_t_updated_by' => 'int',
		'r_t_deleted_by' => 'int'
	];

	protected $dates = [
		'r_t_tanggal',
		'r_t_created_at',
		'r_t_updated_at',
		'r_t_deleted_at'
	];

	protected $fillable = [
		'r_t_id',
		'r_t_rekap_modal_id',
		'r_t_nota_code',
		'r_t_bigboss',
		'r_t_member_id',
		'r_t_tanggal',
		'r_t_jam',
		'r_t_m_area_id',
		'r_t_m_area_code',
		'r_t_m_area_nama',
		'r_t_m_w_id',
		'r_t_m_w_code',
		'r_t_m_w_nama',
		'r_t_nominal',
		'r_t_nominal_pajak',
		'r_t_nominal_sc',
		'r_t_nominal_sharing_profit_in',
		'r_t_nominal_sharing_profit_out',
		'r_t_nominal_diskon',
		'r_t_nominal_voucher',
		'r_t_nominal_pembulatan',
		'r_t_nominal_tarik_tunai',
		'r_t_nominal_total_bayar',
		'r_t_nominal_total_uang',
		'r_t_nominal_kembalian',
		'r_t_nominal_free_kembalian',
		'r_t_nominal_total_kembalian',
		'r_t_tax_percent',
		'r_t_sc_percent',
		'r_t_m_t_t_id',
		'r_t_status',
		'r_t_catatan',
		'r_t_status_sync',
		'r_t_created_by',
		'r_t_updated_by',
		'r_t_deleted_by',
		'r_t_created_at',
		'r_t_updated_at',
		'r_t_deleted_at'
	];
}
