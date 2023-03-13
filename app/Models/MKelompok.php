<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MKelompok
 * 
 * @property int $m_kelompok_id
 * @property string $m_kelompok_nama
 * @property int $m_kelompok_created_by
 * @property int|null $m_kelompok_updated_by
 * @property int|null $m_kelompok_deleted_by
 * @property Carbon $m_kelompok_created_at
 * @property Carbon|null $m_kelompok_updated_at
 * @property Carbon|null $m_kelompok_deleted_at
 *
 * @package App\Models
 */
class MKelompok extends Model
{
	protected $table = 'm_kelompok';
	protected $primaryKey = 'm_kelompok_id';
	public $timestamps = false;

	protected $casts = [
		'm_kelompok_created_by' => 'int',
		'm_kelompok_updated_by' => 'int',
		'm_kelompok_deleted_by' => 'int'
	];

	protected $dates = [
		'm_kelompok_created_at',
		'm_kelompok_updated_at',
		'm_kelompok_deleted_at'
	];

	protected $fillable = [
		'm_kelompok_nama',
		'm_kelompok_created_by',
		'm_kelompok_updated_by',
		'm_kelompok_deleted_by',
		'm_kelompok_created_at',
		'm_kelompok_updated_at',
		'm_kelompok_deleted_at'
	];
}
