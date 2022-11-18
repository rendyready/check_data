<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigFooter
 * 
 * @property int $config_footer_id
 * @property int $config_footer_m_w_id
 * @property string $config_footer_value
 * @property int $config_footer_priority
 * @property int $config_footer_created_by
 * @property int $config_footer_updated_by
 * @property Carbon $config_footer_created_at
 * @property Carbon|null $config_footer_updated_at
 * @property Carbon|null $config_footer_deleted_at
 *
 * @package App\Models
 */
class ConfigFooter extends Model
{
	protected $table = 'config_footer';
	protected $primaryKey = 'config_footer_id';
	public $timestamps = false;

	protected $casts = [
		'config_footer_m_w_id' => 'int',
		'config_footer_priority' => 'int',
		'config_footer_created_by' => 'int',
		'config_footer_updated_by' => 'int'
	];

	protected $dates = [
		'config_footer_created_at',
		'config_footer_updated_at',
		'config_footer_deleted_at'
	];

	protected $fillable = [
		'config_footer_m_w_id',
		'config_footer_value',
		'config_footer_priority',
		'config_footer_created_by',
		'config_footer_updated_by',
		'config_footer_created_at',
		'config_footer_updated_at',
		'config_footer_deleted_at'
	];
}
