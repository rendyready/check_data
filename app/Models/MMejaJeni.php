<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MMejaJeni
 * 
 * @property int $id
 * @property int $m_meja_jenis_id
 * @property string $m_meja_jenis_nama
 * @property int $m_meja_jenis_space
 * @property string|null $m_meja_jenis_status
 * @property int $m_meja_jenis_created_by
 * @property int|null $m_meja_jenis_updated_by
 * @property int|null $m_meja_jenis_deleted_by
 * @property Carbon $m_meja_jenis_created_at
 * @property Carbon|null $m_meja_jenis_updated_at
 * @property Carbon|null $m_meja_jenis_deleted_at
 *
 * @package App\Models
 */
class MMejaJeni extends Model
{
	protected $table = 'm_meja_jenis';
	public $timestamps = false;

	protected $casts = [
		'm_meja_jenis_id' => 'int',
		'm_meja_jenis_space' => 'int',
		'm_meja_jenis_created_by' => 'int',
		'm_meja_jenis_updated_by' => 'int',
		'm_meja_jenis_deleted_by' => 'int'
	];

	protected $dates = [
		'm_meja_jenis_created_at',
		'm_meja_jenis_updated_at',
		'm_meja_jenis_deleted_at'
	];

	protected $fillable = [
		'm_meja_jenis_id',
		'm_meja_jenis_nama',
		'm_meja_jenis_space',
		'm_meja_jenis_status',
		'm_meja_jenis_created_by',
		'm_meja_jenis_updated_by',
		'm_meja_jenis_deleted_by',
		'm_meja_jenis_created_at',
		'm_meja_jenis_updated_at',
		'm_meja_jenis_deleted_at'
	];
}
