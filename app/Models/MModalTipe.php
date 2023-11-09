<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MModalTipe
 * 
 * @property int $id
 * @property int $m_modal_tipe_id
 * @property string $m_modal_tipe_nama
 * @property int|null $m_modal_tipe_parent_id
 * @property float|null $m_modal_tipe_nominal
 * @property float|null $m_modal_tipe_urut
 * @property int $m_modal_tipe_created_by
 * @property int|null $m_modal_tipe_updated_by
 * @property int|null $m_modal_tipe_deleted_by
 * @property Carbon $m_modal_tipe_created_at
 * @property Carbon|null $m_modal_tipe_updated_at
 * @property Carbon|null $m_modal_tipe_deleted_at
 * @property string $m_modal_tipe_status_sync
 *
 * @package App\Models
 */
class MModalTipe extends Model
{
	protected $table = 'm_modal_tipe';
	public $timestamps = false;

	protected $casts = [
		'm_modal_tipe_id' => 'int',
		'm_modal_tipe_parent_id' => 'int',
		'm_modal_tipe_nominal' => 'float',
		'm_modal_tipe_urut' => 'float',
		'm_modal_tipe_created_by' => 'int',
		'm_modal_tipe_updated_by' => 'int',
		'm_modal_tipe_deleted_by' => 'int',
		'm_modal_tipe_created_at' => 'datetime',
		'm_modal_tipe_updated_at' => 'datetime',
		'm_modal_tipe_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_modal_tipe_id',
		'm_modal_tipe_nama',
		'm_modal_tipe_parent_id',
		'm_modal_tipe_nominal',
		'm_modal_tipe_urut',
		'm_modal_tipe_created_by',
		'm_modal_tipe_updated_by',
		'm_modal_tipe_deleted_by',
		'm_modal_tipe_created_at',
		'm_modal_tipe_updated_at',
		'm_modal_tipe_deleted_at',
		'm_modal_tipe_status_sync'
	];
}
