<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapInvPenjualan
 * 
 * @property int $rekap_inv_penjualan_id
 * @property string $rekap_inv_penjualan_code
 * @property Carbon $rekap_inv_penjualan_tgl
 * @property string $rekap_inv_penjualan_jth_tmp
 * @property int $rekap_inv_penjualan_supplier_id
 * @property string $rekap_inv_penjualan_supplier_nama
 * @property string|null $rekap_inv_penjualan_supplier_telp
 * @property string|null $rekap_inv_penjualan_supplier_alamat
 * @property int $rekap_inv_penjualan_m_w_id
 * @property float|null $rekap_inv_penjualan_disc
 * @property float|null $rekap_inv_penjualan_disc_rp
 * @property float|null $rekap_inv_penjualan_ppn
 * @property float|null $rekap_inv_penjualan_ppn_rp
 * @property float|null $rekap_inv_penjualan_ongkir
 * @property float $rekap_inv_penjualan_tot_nom
 * @property float $rekap_inv_penjualan_terbayar
 * @property float $rekap_inv_penjualan_tersisa
 * @property int $rekap_inv_penjualan_created_by
 * @property int|null $rekap_inv_penjualan_updated_by
 * @property int|null $rekap_inv_penjualan_deleted_by
 * @property Carbon $rekap_inv_penjualan_created_at
 * @property Carbon|null $rekap_inv_penjualan_updated_at
 * @property Carbon|null $rekap_inv_penjualan_deleted_at
 *
 * @package App\Models
 */
class RekapInvPenjualan extends Model
{
	protected $table = 'rekap_inv_penjualan';
	protected $primaryKey = 'rekap_inv_penjualan_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_inv_penjualan_tgl' => 'datetime',
		'rekap_inv_penjualan_supplier_id' => 'int',
		'rekap_inv_penjualan_m_w_id' => 'int',
		'rekap_inv_penjualan_disc' => 'float',
		'rekap_inv_penjualan_disc_rp' => 'float',
		'rekap_inv_penjualan_ppn' => 'float',
		'rekap_inv_penjualan_ppn_rp' => 'float',
		'rekap_inv_penjualan_ongkir' => 'float',
		'rekap_inv_penjualan_tot_nom' => 'float',
		'rekap_inv_penjualan_terbayar' => 'float',
		'rekap_inv_penjualan_tersisa' => 'float',
		'rekap_inv_penjualan_created_by' => 'int',
		'rekap_inv_penjualan_updated_by' => 'int',
		'rekap_inv_penjualan_deleted_by' => 'int',
		'rekap_inv_penjualan_created_at' => 'datetime',
		'rekap_inv_penjualan_updated_at' => 'datetime',
		'rekap_inv_penjualan_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'rekap_inv_penjualan_code',
		'rekap_inv_penjualan_tgl',
		'rekap_inv_penjualan_jth_tmp',
		'rekap_inv_penjualan_supplier_id',
		'rekap_inv_penjualan_supplier_nama',
		'rekap_inv_penjualan_supplier_telp',
		'rekap_inv_penjualan_supplier_alamat',
		'rekap_inv_penjualan_m_w_id',
		'rekap_inv_penjualan_disc',
		'rekap_inv_penjualan_disc_rp',
		'rekap_inv_penjualan_ppn',
		'rekap_inv_penjualan_ppn_rp',
		'rekap_inv_penjualan_ongkir',
		'rekap_inv_penjualan_tot_nom',
		'rekap_inv_penjualan_terbayar',
		'rekap_inv_penjualan_tersisa',
		'rekap_inv_penjualan_created_by',
		'rekap_inv_penjualan_updated_by',
		'rekap_inv_penjualan_deleted_by',
		'rekap_inv_penjualan_created_at',
		'rekap_inv_penjualan_updated_at',
		'rekap_inv_penjualan_deleted_at'
	];
}
