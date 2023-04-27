<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelHasPermission
 * 
 * @property int $permission_id
 * @property string $model_type
 * @property int $model_id
 * @property string $m_h_p_status_sync
 * 
 * @property Permission $permission
 *
 * @package App\Models
 */
class ModelHasPermission extends Model
{
	protected $table = 'model_has_permissions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'permission_id' => 'int',
		'model_id' => 'int'
	];

	protected $fillable = [
		'm_h_p_status_sync'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
