<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MLevelJabatan
 * 
 * @property int $m_level_jabatan_id
 * @property string $m_level_jabatan_nama
 * @property int $m_level_jabatan_created_by
 * @property int|null $m_level_jabatan_updated_by
 * @property Carbon $m_level_jabatan_created_at
 * @property Carbon|null $m_level_jabatan_updated_at
 * @property Carbon|null $m_level_jabatan_deleted_at
 *
 * @package App\Models
 */
class MLevelJabatan extends Model
{
	protected $table = 'm_level_jabatan';
	protected $primaryKey = 'm_level_jabatan_id';
	public $timestamps = false;

	protected $casts = [
		'm_level_jabatan_created_by' => 'int',
		'm_level_jabatan_updated_by' => 'int'
	];

	protected $dates = [
		'm_level_jabatan_created_at',
		'm_level_jabatan_updated_at',
		'm_level_jabatan_deleted_at'
	];

	protected $fillable = [
		'm_level_jabatan_nama',
		'm_level_jabatan_created_by',
		'm_level_jabatan_updated_by',
		'm_level_jabatan_created_at',
		'm_level_jabatan_updated_at',
		'm_level_jabatan_deleted_at'
	];
}
