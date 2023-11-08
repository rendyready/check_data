<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppSetting
 * 
 * @property int $app_setting_id
 * @property string|null $app_setting_url_server_struk
 * @property string|null $app_setting_key_server_struk
 * @property int $app_setting_created_by
 * @property int|null $app_setting_updated_by
 * @property int|null $app_setting_deleted_by
 * @property Carbon $app_setting_created_at
 * @property Carbon|null $app_setting_updated_at
 * @property Carbon|null $app_setting_deleted_at
 * @property string $app_setting_status_sync
 *
 * @package App\Models
 */
class AppSetting extends Model
{
	protected $table = 'app_setting';
	protected $primaryKey = 'app_setting_id';
	public $timestamps = false;

	protected $casts = [
		'app_setting_created_by' => 'int',
		'app_setting_updated_by' => 'int',
		'app_setting_deleted_by' => 'int',
		'app_setting_created_at' => 'datetime',
		'app_setting_updated_at' => 'datetime',
		'app_setting_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'app_setting_url_server_struk',
		'app_setting_key_server_struk',
		'app_setting_created_by',
		'app_setting_updated_by',
		'app_setting_deleted_by',
		'app_setting_created_at',
		'app_setting_updated_at',
		'app_setting_deleted_at',
		'app_setting_status_sync'
	];
}
