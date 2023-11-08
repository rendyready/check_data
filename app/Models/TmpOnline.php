<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TmpOnline
 * 
 * @property uuid $tmp_online_id
 * @property int $tmp_online_m_w_id
 * @property string $tmp_online_m_w_nama
 * @property string $tmp_online_code
 * @property int $tmp_online_m_t_t_id
 * @property string $tmp_online_table_id
 * @property string $tmp_online_bigboss_name
 * @property string|null $tmp_online_bigboss_phone
 * @property float $tmp_online_nominal
 * @property float $tmp_online_tax
 * @property float $tmp_online_service
 * @property float $tmp_online_total
 * @property float $tmp_online_tax_val
 * @property float $tmp_online_service_val
 * @property Carbon $tmp_online_date
 * @property time without time zone $tmp_online_time
 * @property string $tmp_online_client_target
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TmpOnline extends Model
{
	protected $table = 'tmp_online';
	protected $primaryKey = 'tmp_online_id';
	public $incrementing = false;

	protected $casts = [
		'tmp_online_id' => 'uuid',
		'tmp_online_m_w_id' => 'int',
		'tmp_online_m_t_t_id' => 'int',
		'tmp_online_table_id' => 'binary',
		'tmp_online_nominal' => 'float',
		'tmp_online_tax' => 'float',
		'tmp_online_service' => 'float',
		'tmp_online_total' => 'float',
		'tmp_online_tax_val' => 'float',
		'tmp_online_service_val' => 'float',
		'tmp_online_date' => 'datetime',
		'tmp_online_time' => 'time without time zone'
	];

	protected $fillable = [
		'tmp_online_m_w_id',
		'tmp_online_m_w_nama',
		'tmp_online_code',
		'tmp_online_m_t_t_id',
		'tmp_online_table_id',
		'tmp_online_bigboss_name',
		'tmp_online_bigboss_phone',
		'tmp_online_nominal',
		'tmp_online_tax',
		'tmp_online_service',
		'tmp_online_total',
		'tmp_online_tax_val',
		'tmp_online_service_val',
		'tmp_online_date',
		'tmp_online_time',
		'tmp_online_client_target'
	];
}
