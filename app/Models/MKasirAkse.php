<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MKasirAkse
 * 
 * @property int $id
 * @property string $m_kasir_akses_id
 * @property int $m_kasir_akses_m_w_id
 * @property string $m_kasir_akses_fitur
 * @property string $m_kasir_akses_default_role
 * @property string $m_kasir_akses_temp_role
 * @property string $m_kasir_akses_sync
 * @property int|null $m_kasir_akses_approvel
 * @property int $m_kasir_akses_created_by
 * @property int|null $m_kasir_akses_updated_by
 * @property int|null $m_kasir_akses_deleted_by
 * @property Carbon $m_kasir_akses_created_at
 * @property Carbon|null $m_kasir_akses_updated_at
 * @property Carbon|null $m_kasir_akses_deleted_at
 * @property string $m_kasir_akses_status_sync
 *
 * @package App\Models
 */
class MKasirAkse extends Model
{
	protected $table = 'm_kasir_akses';
	public $timestamps = false;

	protected $casts = [
		'm_kasir_akses_m_w_id' => 'int',
		'm_kasir_akses_approvel' => 'int',
		'm_kasir_akses_created_by' => 'int',
		'm_kasir_akses_updated_by' => 'int',
		'm_kasir_akses_deleted_by' => 'int',
		'm_kasir_akses_created_at' => 'datetime',
		'm_kasir_akses_updated_at' => 'datetime',
		'm_kasir_akses_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_kasir_akses_id',
		'm_kasir_akses_m_w_id',
		'm_kasir_akses_fitur',
		'm_kasir_akses_default_role',
		'm_kasir_akses_temp_role',
		'm_kasir_akses_sync',
		'm_kasir_akses_approvel',
		'm_kasir_akses_created_by',
		'm_kasir_akses_updated_by',
		'm_kasir_akses_deleted_by',
		'm_kasir_akses_created_at',
		'm_kasir_akses_updated_at',
		'm_kasir_akses_deleted_at',
		'm_kasir_akses_status_sync'
	];
}
