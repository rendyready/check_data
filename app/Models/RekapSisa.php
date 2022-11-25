<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapSisa
 * 
 * @property int $r_s_id
 * @property int $r_s_m_w_id
 * @property string $r_s_m_w_nama
 * @property int $r_s_m_area_id
 * @property string $r_s_m_area_nama
 * @property Carbon $r_s_tanggal
 * @property string $r_s_status_sync
 * @property int $r_s_created_by
 * @property int|null $r_s_updated_by
 * @property Carbon $r_s_created_at
 * @property Carbon|null $r_s_updated_at
 * @property Carbon|null $r_s_deleted_at
 *
 * @package App\Models
 */
class RekapSisa extends Model
{
	protected $table = 'rekap_sisa';
	protected $primaryKey = 'r_s_id';
	public $timestamps = false;

	protected $casts = [
		'r_s_m_w_id' => 'int',
		'r_s_m_area_id' => 'int',
		'r_s_created_by' => 'int',
		'r_s_updated_by' => 'int'
	];

	protected $dates = [
		'r_s_tanggal',
		'r_s_created_at',
		'r_s_updated_at',
		'r_s_deleted_at'
	];

	protected $fillable = [
		'r_s_m_w_id',
		'r_s_m_w_nama',
		'r_s_m_area_id',
		'r_s_m_area_nama',
		'r_s_tanggal',
		'r_s_status_sync',
		'r_s_created_by',
		'r_s_updated_by',
		'r_s_created_at',
		'r_s_updated_at',
		'r_s_deleted_at'
	];
}
