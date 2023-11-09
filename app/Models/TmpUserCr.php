<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TmpUserCr
 * 
 * @property uuid $tmp_user_cr_id
 * @property int $tmp_user_cr_users_id
 * @property int $tmp_user_cr_m_w_id
 * @property Carbon $tmp_user_cr_date
 *
 * @package App\Models
 */
class TmpUserCr extends Model
{
	protected $table = 'tmp_user_cr';
	protected $primaryKey = 'tmp_user_cr_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tmp_user_cr_id' => 'uuid',
		'tmp_user_cr_users_id' => 'int',
		'tmp_user_cr_m_w_id' => 'int',
		'tmp_user_cr_date' => 'datetime'
	];

	protected $fillable = [
		'tmp_user_cr_users_id',
		'tmp_user_cr_m_w_id',
		'tmp_user_cr_date'
	];
}
