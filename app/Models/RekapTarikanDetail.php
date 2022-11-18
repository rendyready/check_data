<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapTarikanDetail
 * 
 * @property int $r_t_d_id
 * @property int $r_t_d_r_t_k_id
 * @property string $r_t_d_key
 * @property string $r_t_d_value
 * @property string $r_t_d_status_sync
 * @property int $r_t_d_created_by
 * @property int|null $r_t_d_updated_by
 * @property Carbon $r_t_d_created_at
 * @property Carbon|null $r_t_d_updated_at
 * @property Carbon|null $r_t_d_deleted_at
 *
 * @package App\Models
 */
class RekapTarikanDetail extends Model
{
	protected $table = 'rekap_tarikan_detail';
	protected $primaryKey = 'r_t_d_id';
	public $timestamps = false;

	protected $casts = [
		'r_t_d_r_t_k_id' => 'int',
		'r_t_d_created_by' => 'int',
		'r_t_d_updated_by' => 'int'
	];

	protected $dates = [
		'r_t_d_created_at',
		'r_t_d_updated_at',
		'r_t_d_deleted_at'
	];

	protected $fillable = [
		'r_t_d_r_t_k_id',
		'r_t_d_key',
		'r_t_d_value',
		'r_t_d_status_sync',
		'r_t_d_created_by',
		'r_t_d_updated_by',
		'r_t_d_created_at',
		'r_t_d_updated_at',
		'r_t_d_deleted_at'
	];
}
