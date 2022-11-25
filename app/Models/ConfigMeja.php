<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigMeja
 * 
 * @property int $config_meja_id
 * @property string $config_meja_nama
 * @property int $config_meja_m_meja_jenis_id
 * @property int $config_meja_m_w_id
 * @property string $config_meja_type
 * @property string $config_meja_status_sync
 * @property int $config_meja_created_by
 * @property Carbon $config_meja_created_at
 * @property int|null $config_meja_updated_by
 * @property Carbon|null $config_meja_updated_at
 * @property Carbon|null $config_meja_deleted_at
 *
 * @package App\Models
 */
class ConfigMeja extends Model
{
	protected $table = 'config_meja';
	protected $primaryKey = 'config_meja_id';
	public $timestamps = false;

	protected $casts = [
		'config_meja_m_meja_jenis_id' => 'int',
		'config_meja_m_w_id' => 'int',
		'config_meja_created_by' => 'int',
		'config_meja_updated_by' => 'int'
	];

	protected $dates = [
		'config_meja_created_at',
		'config_meja_updated_at',
		'config_meja_deleted_at'
	];

	protected $fillable = [
		'config_meja_nama',
		'config_meja_m_meja_jenis_id',
		'config_meja_m_w_id',
		'config_meja_type',
		'config_meja_status_sync',
		'config_meja_created_by',
		'config_meja_created_at',
		'config_meja_updated_by',
		'config_meja_updated_at',
		'config_meja_deleted_at'
	];
}
