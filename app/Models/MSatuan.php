<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MSatuan
 * 
 * @property int $id
 * @property int $m_satuan_id
 * @property string $m_satuan_kode
 * @property string|null $m_satuan_keterangan
 * @property int $m_satuan_created_by
 * @property int|null $m_satuan_updated_by
 * @property int|null $m_satuan_deleted_by
 * @property Carbon $m_satuan_created_at
 * @property Carbon|null $m_satuan_updated_at
 * @property Carbon|null $m_satuan_deleted_at
 * @property string $m_satuan_status_sync
 *
 * @package App\Models
 */
class MSatuan extends Model
{
	protected $table = 'm_satuan';
	public $timestamps = false;

	protected $casts = [
		'm_satuan_id' => 'int',
		'm_satuan_created_by' => 'int',
		'm_satuan_updated_by' => 'int',
		'm_satuan_deleted_by' => 'int',
		'm_satuan_created_at' => 'datetime',
		'm_satuan_updated_at' => 'datetime',
		'm_satuan_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_satuan_id',
		'm_satuan_kode',
		'm_satuan_keterangan',
		'm_satuan_created_by',
		'm_satuan_updated_by',
		'm_satuan_deleted_by',
		'm_satuan_created_at',
		'm_satuan_updated_at',
		'm_satuan_deleted_at',
		'm_satuan_status_sync'
	];
}
