<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MWJeni
 * 
 * @property int $id
 * @property string $m_w_jenis_nama
 * @property int $m_w_jenis_created_by
 * @property Carbon $m_w_jenis_created_at
 * @property int|null $m_w_jenis_updated_by
 * @property Carbon|null $m_w_jenis_updated_at
 * @property Carbon|null $m_w_jenis_deleted_at
 *
 * @package App\Models
 */
class MWJeni extends Model
{
	protected $table = 'm_w_jenis';
	public $timestamps = false;

	protected $casts = [
		'm_w_jenis_created_by' => 'int',
		'm_w_jenis_updated_by' => 'int'
	];

	protected $dates = [
		'm_w_jenis_created_at',
		'm_w_jenis_updated_at',
		'm_w_jenis_deleted_at'
	];

	protected $fillable = [
		'm_w_jenis_nama',
		'm_w_jenis_created_by',
		'm_w_jenis_created_at',
		'm_w_jenis_updated_by',
		'm_w_jenis_updated_at',
		'm_w_jenis_deleted_at'
	];
}
