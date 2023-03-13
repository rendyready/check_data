<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJenisNotum
 * 
 * @property int $id
 * @property int $m_jenis_nota_id
 * @property int $m_jenis_nota_m_w_id
 * @property int $m_jenis_nota_m_t_t_id
 * @property int $m_jenis_nota_created_by
 * @property int|null $m_jenis_nota_updated_by
 * @property int|null $m_jenis_nota_deleted_by
 * @property Carbon $m_jenis_nota_created_at
 * @property Carbon|null $m_jenis_nota_updated_at
 * @property Carbon|null $m_jenis_nota_deleted_at
 *
 * @package App\Models
 */
class MJenisNotum extends Model
{
	protected $table = 'm_jenis_nota';
	public $timestamps = false;

	protected $casts = [
		'm_jenis_nota_id' => 'int',
		'm_jenis_nota_m_w_id' => 'int',
		'm_jenis_nota_m_t_t_id' => 'int',
		'm_jenis_nota_created_by' => 'int',
		'm_jenis_nota_updated_by' => 'int',
		'm_jenis_nota_deleted_by' => 'int'
	];

	protected $dates = [
		'm_jenis_nota_created_at',
		'm_jenis_nota_updated_at',
		'm_jenis_nota_deleted_at'
	];

	protected $fillable = [
		'm_jenis_nota_id',
		'm_jenis_nota_m_w_id',
		'm_jenis_nota_m_t_t_id',
		'm_jenis_nota_created_by',
		'm_jenis_nota_updated_by',
		'm_jenis_nota_deleted_by',
		'm_jenis_nota_created_at',
		'm_jenis_nota_updated_at',
		'm_jenis_nota_deleted_at'
	];
}
