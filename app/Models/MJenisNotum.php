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
 * @property int $m_jenis_nota_id
 * @property string $m_jenis_nota_nama
 * @property int $m_jenis_nota_created_by
 * @property Carbon $m_jenis_nota_created_at
 * @property int|null $m_jenis_nota_updated_by
 * @property Carbon|null $m_jenis_nota_updated_at
 * @property Carbon|null $m_jenis_nota_deleted_at
 *
 * @package App\Models
 */
class MJenisNotum extends Model
{
	protected $table = 'm_jenis_nota';
	protected $primaryKey = 'm_jenis_nota_id';
	public $timestamps = false;

	protected $casts = [
		'm_jenis_nota_created_by' => 'int',
		'm_jenis_nota_updated_by' => 'int'
	];

	protected $dates = [
		'm_jenis_nota_created_at',
		'm_jenis_nota_updated_at',
		'm_jenis_nota_deleted_at'
	];

	protected $fillable = [
		'm_jenis_nota_nama',
		'm_jenis_nota_created_by',
		'm_jenis_nota_created_at',
		'm_jenis_nota_updated_by',
		'm_jenis_nota_updated_at',
		'm_jenis_nota_deleted_at'
	];
}
