<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPesanan
 * 
 * @property int $r_p_id
 * @property int $r_p_m_menu_id
 * @property string|null $r_p_m_menu_code
 * @property string $r_p_m_menu_nama
 * @property string $r_p_m_menu_cr
 * @property string $r_p_m_menu_urut
 * @property float $r_p_m_menu_harga_nominal
 * @property int $r_p_m_r_t_id
 * @property Carbon $r_p_tanggal
 * @property time without time zone $r_p_jam
 * @property int $r_p_m_menu_jenis_id
 * @property string $r_p_m_menu_jenis_nama
 * @property string $r_p_custom
 * @property int $r_p_qty
 * @property Carbon $r_p_jam_input
 * @property Carbon|null $r_p_jam_order
 * @property Carbon|null $r_p_jam_tata
 * @property Carbon|null $r_p_jam_saji
 * @property int|null $r_p_durasi_produksi
 * @property int|null $r_p_durasi_saji
 * @property int|null $r_p_durasi_pelayanan
 * @property float $r_p_nominal
 * @property string $r_p_status
 * @property string|null $r_p_tax_status
 * @property string|null $r_p_sc_status
 * @property string $r_p_status_sync
 * @property int $r_p_created_by
 * @property int|null $r_p_updated_by
 * @property Carbon $r_p_created_at
 * @property Carbon|null $r_p_updated_at
 * @property Carbon|null $r_p_deleted_at
 *
 * @package App\Models
 */
class RekapPesanan extends Model
{
	protected $table = 'rekap_pesanan';
	protected $primaryKey = 'r_p_id';
	public $timestamps = false;

	protected $casts = [
		'r_p_m_menu_id' => 'int',
		'r_p_m_menu_harga_nominal' => 'float',
		'r_p_m_r_t_id' => 'int',
		'r_p_jam' => 'time without time zone',
		'r_p_m_menu_jenis_id' => 'int',
		'r_p_qty' => 'int',
		'r_p_durasi_produksi' => 'int',
		'r_p_durasi_saji' => 'int',
		'r_p_durasi_pelayanan' => 'int',
		'r_p_nominal' => 'float',
		'r_p_created_by' => 'int',
		'r_p_updated_by' => 'int'
	];

	protected $dates = [
		'r_p_tanggal',
		'r_p_jam_input',
		'r_p_jam_order',
		'r_p_jam_tata',
		'r_p_jam_saji',
		'r_p_created_at',
		'r_p_updated_at',
		'r_p_deleted_at'
	];

	protected $fillable = [
		'r_p_m_menu_id',
		'r_p_m_menu_code',
		'r_p_m_menu_nama',
		'r_p_m_menu_cr',
		'r_p_m_menu_urut',
		'r_p_m_menu_harga_nominal',
		'r_p_m_r_t_id',
		'r_p_tanggal',
		'r_p_jam',
		'r_p_m_menu_jenis_id',
		'r_p_m_menu_jenis_nama',
		'r_p_custom',
		'r_p_qty',
		'r_p_jam_input',
		'r_p_jam_order',
		'r_p_jam_tata',
		'r_p_jam_saji',
		'r_p_durasi_produksi',
		'r_p_durasi_saji',
		'r_p_durasi_pelayanan',
		'r_p_nominal',
		'r_p_status',
		'r_p_tax_status',
		'r_p_sc_status',
		'r_p_status_sync',
		'r_p_created_by',
		'r_p_updated_by',
		'r_p_created_at',
		'r_p_updated_at',
		'r_p_deleted_at'
	];
}
