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
 * @property int $m_jabatan_id
 * @property int $m_jabatan_m_level_jabatan_id
 * @property string $m_jabatan_nama
 * @property int|null $m_jabatan_parent_id
 * @property int $m_jabatan_created_by
 * @property int|null $m_jabatan_updated_by
 * @property Carbon $m_jabatan_created_at
 * @property Carbon|null $m_jabatan_updated_at
 * @property Carbon|null $m_jabatan_deleted_at
 *
 * @package App\Models
 */
class MJabatan extends Model
{
	protected $table = 'm_jabatan';
	protected $primaryKey = 'm_jabatan_id';
	public $timestamps = false;

	protected $casts = [
		'm_jabatan_m_level_jabatan_id' => 'int',
		'm_jabatan_parent_id' => 'int',
		'm_jabatan_created_by' => 'int',
		'm_jabatan_updated_by' => 'int'
	];

	protected $dates = [
		'm_jabatan_created_at',
		'm_jabatan_updated_at',
		'm_jabatan_deleted_at'
	];

	protected $fillable = [
		'm_jabatan_m_level_jabatan_id',
		'm_jabatan_nama',
		'm_jabatan_parent_id',
		'm_jabatan_created_by',
		'm_jabatan_updated_by',
		'm_jabatan_created_at',
		'm_jabatan_updated_at',
		'm_jabatan_deleted_at'
	];
}
