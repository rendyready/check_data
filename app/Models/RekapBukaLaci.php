<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapBukaLaci
 * 
 * @property int $r_b_l_id
 * @property Carbon $r_b_l_tanggal
 * @property int $r_b_l_shift
 * @property time without time zone $r_b_l_jam
 * @property string $r_b_l_keterangan
 * @property int $r_b_l_m_w_id
 * @property string $r_b_l_m_w_nama
 * @property int $r_b_l_kasir_id
 * @property string $r_b_l_kasir_nama
 * @property string $r_b_l_status_sync
 * @property int $r_b_l_created_by
 * @property int|null $r_b_l_updated_by
 * @property Carbon $r_b_l_created_at
 * @property Carbon|null $r_b_l_updated_at
 * @property Carbon|null $r_b_l_deleted_at
 *
 * @package App\Models
 */
class RekapBukaLaci extends Model
{
	protected $table = 'rekap_buka_laci';
	protected $primaryKey = 'r_b_l_id';
	public $timestamps = false;

	protected $casts = [
		'r_b_l_shift' => 'int',
		'r_b_l_jam' => 'time without time zone',
		'r_b_l_m_w_id' => 'int',
		'r_b_l_kasir_id' => 'int',
		'r_b_l_created_by' => 'int',
		'r_b_l_updated_by' => 'int'
	];

	protected $dates = [
		'r_b_l_tanggal',
		'r_b_l_created_at',
		'r_b_l_updated_at',
		'r_b_l_deleted_at'
	];

	protected $fillable = [
		'r_b_l_tanggal',
		'r_b_l_shift',
		'r_b_l_jam',
		'r_b_l_keterangan',
		'r_b_l_m_w_id',
		'r_b_l_m_w_nama',
		'r_b_l_kasir_id',
		'r_b_l_kasir_nama',
		'r_b_l_status_sync',
		'r_b_l_created_by',
		'r_b_l_updated_by',
		'r_b_l_created_at',
		'r_b_l_updated_at',
		'r_b_l_deleted_at'
	];
}
