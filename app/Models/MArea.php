<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MArea
 * 
 * @property int $id
 * @property string $m_area_nama
 * @property int $m_area_created_by
 * @property Carbon $m_area_created_at
 * @property int|null $m_area_updated_by
 * @property Carbon|null $m_area_updated_at
 * @property Carbon|null $m_area_deleted_at
 *
 * @package App\Models
 */
class MArea extends Model
{
	protected $table = 'm_area';
	public $timestamps = false;

	protected $casts = [
		'm_area_created_by' => 'int',
		'm_area_updated_by' => 'int'
	];

	protected $dates = [
		'm_area_created_at',
		'm_area_updated_at',
		'm_area_deleted_at'
	];

	protected $fillable = [
		'm_area_nama',
		'm_area_created_by',
		'm_area_created_at',
		'm_area_updated_by',
		'm_area_updated_at',
		'm_area_deleted_at'
	];
}
