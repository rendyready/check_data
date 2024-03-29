<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MArea
 * 
 * @property int $id
 * @property int $m_area_id
 * @property string $m_area_nama
 * @property string $m_area_code
 * @property int $m_area_created_by
 * @property int|null $m_area_updated_by
 * @property int|null $m_area_deleted_by
 * @property Carbon $m_area_created_at
 * @property Carbon|null $m_area_updated_at
 * @property Carbon|null $m_area_deleted_at
 * @property string $m_area_status_sync
 *
 * @package App\Models
 */
class MArea extends Model
{
	protected $table = 'm_area';
	public $timestamps = false;

	protected $casts = [
		'm_area_id' => 'int',
		'm_area_created_by' => 'int',
		'm_area_updated_by' => 'int',
		'm_area_deleted_by' => 'int',
		'm_area_created_at' => 'datetime',
		'm_area_updated_at' => 'datetime',
		'm_area_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_area_id',
		'm_area_nama',
		'm_area_code',
		'm_area_created_by',
		'm_area_updated_by',
		'm_area_deleted_by',
		'm_area_created_at',
		'm_area_updated_at',
		'm_area_deleted_at',
		'm_area_status_sync'
	];
	public function m_ws()
	{
		return $this->hasMany(MW::class, 'm_w_m_area_id');
	}
}
