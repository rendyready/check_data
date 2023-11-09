<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MWJeni
 * 
 * @property int $id
 * @property int $m_w_jenis_id
 * @property string $m_w_jenis_nama
 * @property int $m_w_jenis_created_by
 * @property int|null $m_w_jenis_updated_by
 * @property int|null $m_w_jenis_deleted_by
 * @property Carbon $m_w_jenis_created_at
 * @property Carbon|null $m_w_jenis_updated_at
 * @property Carbon|null $m_w_jenis_deleted_at
 * @property string $m_w_jenis_status_sync
 *
 * @package App\Models
 */
class MWJeni extends Model
{
	protected $table = 'm_w_jenis';
	public $timestamps = false;

	protected $casts = [
		'm_w_jenis_id' => 'int',
		'm_w_jenis_created_by' => 'int',
		'm_w_jenis_updated_by' => 'int',
		'm_w_jenis_deleted_by' => 'int',
		'm_w_jenis_created_at' => 'datetime',
		'm_w_jenis_updated_at' => 'datetime',
		'm_w_jenis_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_w_jenis_id',
		'm_w_jenis_nama',
		'm_w_jenis_created_by',
		'm_w_jenis_updated_by',
		'm_w_jenis_deleted_by',
		'm_w_jenis_created_at',
		'm_w_jenis_updated_at',
		'm_w_jenis_deleted_at',
		'm_w_jenis_status_sync'
	];
}
