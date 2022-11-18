<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapSisaDetail
 * 
 * @property int $r_s_d_id
 * @property int $r_s_d_r_s_id
 * @property int $r_s_d_m_produk_id
 * @property string $r_s_d_m_menu_code
 * @property string $r_s_d_m_produk_nama
 * @property string $r_s_d_m_menu_cr
 * @property string $r_s_d_m_menu_urut
 * @property int $r_s_d_m_jenis_produk_id
 * @property string $r_s_d_m_jenis_produk_nama
 * @property int $r_s_d_qty
 * @property string $r_s_d_status_sync
 * @property Carbon $r_s_d_created_by
 * @property Carbon|null $r_s_d_updated_by
 * @property Carbon $r_s_d_created_at
 * @property Carbon|null $r_s_d_updated_at
 * @property Carbon|null $r_s_d_deleted_at
 *
 * @package App\Models
 */
class RekapSisaDetail extends Model
{
	protected $table = 'rekap_sisa_detail';
	protected $primaryKey = 'r_s_d_id';
	public $timestamps = false;

	protected $casts = [
		'r_s_d_r_s_id' => 'int',
		'r_s_d_m_produk_id' => 'int',
		'r_s_d_m_jenis_produk_id' => 'int',
		'r_s_d_qty' => 'int'
	];

	protected $dates = [
		'r_s_d_created_by',
		'r_s_d_updated_by',
		'r_s_d_created_at',
		'r_s_d_updated_at',
		'r_s_d_deleted_at'
	];

	protected $fillable = [
		'r_s_d_r_s_id',
		'r_s_d_m_produk_id',
		'r_s_d_m_menu_code',
		'r_s_d_m_produk_nama',
		'r_s_d_m_menu_cr',
		'r_s_d_m_menu_urut',
		'r_s_d_m_jenis_produk_id',
		'r_s_d_m_jenis_produk_nama',
		'r_s_d_qty',
		'r_s_d_status_sync',
		'r_s_d_created_by',
		'r_s_d_updated_by',
		'r_s_d_created_at',
		'r_s_d_updated_at',
		'r_s_d_deleted_at'
	];
}
