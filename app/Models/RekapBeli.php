<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapBeli
 * 
 * @property int $id
 * @property string $rekap_beli_id
 * @property string $rekap_beli_code
 * @property string|null $rekap_beli_code_nota
 * @property Carbon $rekap_beli_tgl
 * @property string $rekap_beli_jth_tmp
 * @property string $rekap_beli_supplier_code
 * @property string $rekap_beli_gudang_code
 * @property string $rekap_beli_supplier_nama
 * @property string|null $rekap_beli_supplier_telp
 * @property string|null $rekap_beli_supplier_alamat
 * @property int $rekap_beli_m_w_id
 * @property string $rekap_beli_waroeng
 * @property float|null $rekap_beli_disc
 * @property float|null $rekap_beli_disc_rp
 * @property float|null $rekap_beli_ppn
 * @property float|null $rekap_beli_ppn_rp
 * @property float|null $rekap_beli_ongkir
 * @property float $rekap_beli_terbayar
 * @property float $rekap_beli_tersisa
 * @property float $rekap_beli_tot_nom
 * @property string|null $rekap_beli_ket
 * @property int $rekap_beli_created_by
 * @property int|null $rekap_beli_updated_by
 * @property int|null $rekap_beli_deleted_by
 * @property Carbon $rekap_beli_created_at
 * @property Carbon|null $rekap_beli_updated_at
 * @property Carbon|null $rekap_beli_deleted_at
 *
 * @package App\Models
 */
class RekapBeli extends Model
{
	protected $table = 'rekap_beli';
	public $timestamps = false;

	protected $casts = [
		'rekap_beli_m_w_id' => 'int',
		'rekap_beli_disc' => 'float',
		'rekap_beli_disc_rp' => 'float',
		'rekap_beli_ppn' => 'float',
		'rekap_beli_ppn_rp' => 'float',
		'rekap_beli_ongkir' => 'float',
		'rekap_beli_terbayar' => 'float',
		'rekap_beli_tersisa' => 'float',
		'rekap_beli_tot_nom' => 'float',
		'rekap_beli_created_by' => 'int',
		'rekap_beli_updated_by' => 'int',
		'rekap_beli_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_beli_tgl',
		'rekap_beli_created_at',
		'rekap_beli_updated_at',
		'rekap_beli_deleted_at'
	];

	protected $fillable = [
		'rekap_beli_id',
		'rekap_beli_code',
		'rekap_beli_code_nota',
		'rekap_beli_tgl',
		'rekap_beli_jth_tmp',
		'rekap_beli_supplier_code',
		'rekap_beli_gudang_code',
		'rekap_beli_supplier_nama',
		'rekap_beli_supplier_telp',
		'rekap_beli_supplier_alamat',
		'rekap_beli_m_w_id',
		'rekap_beli_waroeng',
		'rekap_beli_disc',
		'rekap_beli_disc_rp',
		'rekap_beli_ppn',
		'rekap_beli_ppn_rp',
		'rekap_beli_ongkir',
		'rekap_beli_terbayar',
		'rekap_beli_tersisa',
		'rekap_beli_tot_nom',
		'rekap_beli_ket',
		'rekap_beli_created_by',
		'rekap_beli_updated_by',
		'rekap_beli_deleted_by',
		'rekap_beli_created_at',
		'rekap_beli_updated_at',
		'rekap_beli_deleted_at'
	];
}
