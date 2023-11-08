<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MDivisi
 * 
 * @property int $id
 * @property string $m_divisi_id
 * @property string|null $m_divisi_parent_id
 * @property string $m_divisi_name
 * @property int $m_divisi_created_by
 * @property string $m_divisi_created_by_name
 * @property int|null $m_divisi_updated_by
 * @property int|null $m_divisi_deleted_by
 * @property Carbon $m_divisi_created_at
 * @property Carbon|null $m_divisi_updated_at
 * @property Carbon|null $m_divisi_deleted_at
 * @property string $m_divisi_status_sync
 *
 * @package App\Models
 */
class MDivisi extends Model
{
	protected $table = 'm_divisi';
	public $timestamps = false;

	protected $casts = [
		'm_divisi_created_by' => 'int',
		'm_divisi_updated_by' => 'int',
		'm_divisi_deleted_by' => 'int',
		'm_divisi_created_at' => 'datetime',
		'm_divisi_updated_at' => 'datetime',
		'm_divisi_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_divisi_id',
		'm_divisi_parent_id',
		'm_divisi_name',
		'm_divisi_created_by',
		'm_divisi_created_by_name',
		'm_divisi_updated_by',
		'm_divisi_deleted_by',
		'm_divisi_created_at',
		'm_divisi_updated_at',
		'm_divisi_deleted_at',
		'm_divisi_status_sync'
	];
}
