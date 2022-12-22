<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MMeja
 * 
 * @property int $m_meja_id
 * @property string $m_meja_nama
 * @property int $m_meja_m_meja_jenis_id
 * @property int $m_meja_m_w_id
 * @property string $m_meja_type
 * @property string $m_meja_status_sync
 * @property int $m_meja_created_by
 * @property int|null $m_meja_updated_by
 * @property int|null $m_meja_deleted_by
 * @property Carbon $m_meja_created_at
 * @property Carbon|null $m_meja_updated_at
 * @property Carbon|null $m_meja_deleted_at
 *
 * @package App\Models
 */
class MMeja extends Model
{
	protected $table = 'm_meja';
	protected $primaryKey = 'm_meja_id';
	public $timestamps = false;

	protected $casts = [
		'm_meja_m_meja_jenis_id' => 'int',
		'm_meja_m_w_id' => 'int',
		'm_meja_created_by' => 'int',
		'm_meja_updated_by' => 'int',
		'm_meja_deleted_by' => 'int'
	];

	protected $dates = [
		'm_meja_created_at',
		'm_meja_updated_at',
		'm_meja_deleted_at'
	];

	protected $fillable = [
		'm_meja_nama',
		'm_meja_m_meja_jenis_id',
		'm_meja_m_w_id',
		'm_meja_type',
		'm_meja_status_sync',
		'm_meja_created_by',
		'm_meja_updated_by',
		'm_meja_deleted_by',
		'm_meja_created_at',
		'm_meja_updated_at',
		'm_meja_deleted_at'
	];
}
