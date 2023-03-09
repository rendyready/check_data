<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MPajak
 * 
 * @property int $id
 * @property int $m_pajak_id
 * @property float $m_pajak_value
 * @property int $m_pajak_created_by
 * @property int|null $m_pajak_updated_by
 * @property int|null $m_pajak_deleted_by
 * @property Carbon $m_pajak_created_at
 * @property Carbon|null $m_pajak_updated_at
 * @property Carbon|null $m_pajak_deleted_at
 *
 * @package App\Models
 */
class MPajak extends Model
{
	protected $table = 'm_pajak';
	public $timestamps = false;

	protected $casts = [
		'm_pajak_id' => 'int',
		'm_pajak_value' => 'float',
		'm_pajak_created_by' => 'int',
		'm_pajak_updated_by' => 'int',
		'm_pajak_deleted_by' => 'int'
	];

	protected $dates = [
		'm_pajak_created_at',
		'm_pajak_updated_at',
		'm_pajak_deleted_at'
	];

	protected $fillable = [
		'm_pajak_id',
		'm_pajak_value',
		'm_pajak_created_by',
		'm_pajak_updated_by',
		'm_pajak_deleted_by',
		'm_pajak_created_at',
		'm_pajak_updated_at',
		'm_pajak_deleted_at'
	];
}
