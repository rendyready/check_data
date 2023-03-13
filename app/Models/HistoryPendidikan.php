<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryPendidikan
 * 
 * @property int $id
 * @property string $history_pendidikan_id
 * @property string $history_pendidikan_m_karyawan_id
 * @property string $history_pendidikan_jenjang
 * @property string $history_pendidikan_institut
 * @property string|null $history_pendidikan_jurusan
 * @property string|null $history_pendidikan_tahun_masuk
 * @property string|null $history_pendidikan_tahun_lulus
 * @property float|null $history_pendidikan_nilai
 * @property int $history_pendidikan_created_by
 * @property int|null $history_pendidikan_updated_by
 * @property int|null $history_pendidikan_deleted_by
 * @property Carbon $history_pendidikan_created_at
 * @property Carbon|null $history_pendidikan_updated_at
 * @property Carbon|null $history_pendidikan_deleted_at
 *
 * @package App\Models
 */
class HistoryPendidikan extends Model
{
	protected $table = 'history_pendidikan';
	public $timestamps = false;

	protected $casts = [
		'history_pendidikan_nilai' => 'float',
		'history_pendidikan_created_by' => 'int',
		'history_pendidikan_updated_by' => 'int',
		'history_pendidikan_deleted_by' => 'int'
	];

	protected $dates = [
		'history_pendidikan_created_at',
		'history_pendidikan_updated_at',
		'history_pendidikan_deleted_at'
	];

	protected $fillable = [
		'history_pendidikan_id',
		'history_pendidikan_m_karyawan_id',
		'history_pendidikan_jenjang',
		'history_pendidikan_institut',
		'history_pendidikan_jurusan',
		'history_pendidikan_tahun_masuk',
		'history_pendidikan_tahun_lulus',
		'history_pendidikan_nilai',
		'history_pendidikan_created_by',
		'history_pendidikan_updated_by',
		'history_pendidikan_deleted_by',
		'history_pendidikan_created_at',
		'history_pendidikan_updated_at',
		'history_pendidikan_deleted_at'
	];
}
