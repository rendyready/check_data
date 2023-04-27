<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppIdCounter
 * 
 * @property int $id
 * @property int $app_id_counter_m_w_id
 * @property string $app_id_counter_table
 * @property int $app_id_counter_value
 * @property Carbon $app_id_counter_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AppIdCounter extends Model
{
	protected $table = 'app_id_counter';

	protected $casts = [
		'app_id_counter_m_w_id' => 'int',
		'app_id_counter_value' => 'int',
		'app_id_counter_date' => 'datetime'
	];

	protected $fillable = [
		'app_id_counter_m_w_id',
		'app_id_counter_table',
		'app_id_counter_value',
		'app_id_counter_date'
	];
}
