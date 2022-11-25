<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryJabatan
 * 
 * @property int $history_jabatan_id
 * @property int $history_jabatan_m_karyawan_id
 * @property int $history_jabatan_m_jabatan_id
 * @property Carbon $history_jabatan_mulai
 * @property Carbon|null $history_jabatan_selesai
 * @property int $history_jabatan_created_by
 * @property int|null $history_jabatan_updated_by
 * @property Carbon $history_jabatan_created_at
 * @property Carbon|null $history_jabatan_updated_at
 * @property Carbon|null $history_jabatan_deleted_at
 *
 * @package App\Models
 */
class HistoryJabatan extends Model
{
	protected $table = 'history_jabatan';
	protected $primaryKey = 'history_jabatan_id';
	public $timestamps = false;

	protected $casts = [
		'history_jabatan_m_karyawan_id' => 'int',
		'history_jabatan_m_jabatan_id' => 'int',
		'history_jabatan_created_by' => 'int',
		'history_jabatan_updated_by' => 'int'
	];

	protected $dates = [
		'history_jabatan_mulai',
		'history_jabatan_selesai',
		'history_jabatan_created_at',
		'history_jabatan_updated_at',
		'history_jabatan_deleted_at'
	];

	protected $fillable = [
		'history_jabatan_m_karyawan_id',
		'history_jabatan_m_jabatan_id',
		'history_jabatan_mulai',
		'history_jabatan_selesai',
		'history_jabatan_created_by',
		'history_jabatan_updated_by',
		'history_jabatan_created_at',
		'history_jabatan_updated_at',
		'history_jabatan_deleted_at'
	];
}
