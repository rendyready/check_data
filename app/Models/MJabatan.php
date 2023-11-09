<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJabatan
 * 
 * @property int $id
 * @property string $m_jabatan_id
 * @property string $m_jabatan_m_level_jabatan_id
 * @property string $m_jabatan_nama
 * @property string|null $m_jabatan_parent_id
 * @property string $m_jabatan_status_sync
 * @property int $m_jabatan_created_by
 * @property int|null $m_jabatan_updated_by
 * @property int|null $m_jabatan_deleted_by
 * @property Carbon $m_jabatan_created_at
 * @property Carbon|null $m_jabatan_updated_at
 * @property Carbon|null $m_jabatan_deleted_at
 *
 * @package App\Models
 */
class MJabatan extends Model
{
	protected $table = 'm_jabatan';
	public $timestamps = false;

	protected $casts = [
		'm_jabatan_created_by' => 'int',
		'm_jabatan_updated_by' => 'int',
		'm_jabatan_deleted_by' => 'int',
		'm_jabatan_created_at' => 'datetime',
		'm_jabatan_updated_at' => 'datetime',
		'm_jabatan_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_jabatan_id',
		'm_jabatan_m_level_jabatan_id',
		'm_jabatan_nama',
		'm_jabatan_parent_id',
		'm_jabatan_status_sync',
		'm_jabatan_created_by',
		'm_jabatan_updated_by',
		'm_jabatan_deleted_by',
		'm_jabatan_created_at',
		'm_jabatan_updated_at',
		'm_jabatan_deleted_at'
	];
}
