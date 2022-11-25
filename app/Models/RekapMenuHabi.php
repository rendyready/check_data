<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapMenuHabi
 * 
 * @property int $r_m_h_id
 * @property int $r_m_h_m_area_id
 * @property string $r_m_h_m_area_nama
 * @property int $r_m_h_m_w_id
 * @property string $r_m_h_m_w_nama
 * @property int $r_m_h_m_produk_id
 * @property string $r_m_h_m_produk_nama
 * @property string $r_m_h_m_menu_cr
 * @property string $r_m_h_m_menu_urut
 * @property int $r_m_h_m_jenis_produk_id
 * @property string $r_m_h_m_jenis_produk_nama
 * @property string $r_m_h_m_menu_code
 * @property Carbon $r_m_h_tanggal
 * @property string $r_m_h_shift
 * @property time without time zone|null $r_m_h_waktu
 * @property string $r_m_h_status_sync
 * @property int $r_m_h_created_by
 * @property int|null $r_m_h_updated_by
 * @property Carbon $r_m_h_created_at
 * @property Carbon|null $r_m_h_updated_at
 * @property Carbon|null $r_m_h_deleted_at
 *
 * @package App\Models
 */
class RekapMenuHabi extends Model
{
	protected $table = 'rekap_menu_habis';
	protected $primaryKey = 'r_m_h_id';
	public $timestamps = false;

	protected $casts = [
		'r_m_h_m_area_id' => 'int',
		'r_m_h_m_w_id' => 'int',
		'r_m_h_m_produk_id' => 'int',
		'r_m_h_m_jenis_produk_id' => 'int',
		'r_m_h_waktu' => 'time without time zone',
		'r_m_h_created_by' => 'int',
		'r_m_h_updated_by' => 'int'
	];

	protected $dates = [
		'r_m_h_tanggal',
		'r_m_h_created_at',
		'r_m_h_updated_at',
		'r_m_h_deleted_at'
	];

	protected $fillable = [
		'r_m_h_m_area_id',
		'r_m_h_m_area_nama',
		'r_m_h_m_w_id',
		'r_m_h_m_w_nama',
		'r_m_h_m_produk_id',
		'r_m_h_m_produk_nama',
		'r_m_h_m_menu_cr',
		'r_m_h_m_menu_urut',
		'r_m_h_m_jenis_produk_id',
		'r_m_h_m_jenis_produk_nama',
		'r_m_h_m_menu_code',
		'r_m_h_tanggal',
		'r_m_h_shift',
		'r_m_h_waktu',
		'r_m_h_status_sync',
		'r_m_h_created_by',
		'r_m_h_updated_by',
		'r_m_h_created_at',
		'r_m_h_updated_at',
		'r_m_h_deleted_at'
	];
}
