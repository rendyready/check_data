<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ListAkt
 * 
 * @property int $list_akt_id
 * @property string $list_akt_nama
 * @property string|null $list_akt_m_rekening_id
 * @property int $list_akt_created_by
 * @property int|null $list_akt_updated_by
 * @property int|null $list_akt_deleted_by
 * @property Carbon $list_akt_created_at
 * @property Carbon|null $list_akt_updated_at
 * @property Carbon|null $list_akt_deleted_at
 *
 * @package App\Models
 */
class ListAkt extends Model
{
	protected $table = 'list_akt';
	protected $primaryKey = 'list_akt_id';
	public $timestamps = false;

	protected $casts = [
		'list_akt_created_by' => 'int',
		'list_akt_updated_by' => 'int',
		'list_akt_deleted_by' => 'int'
	];

	protected $dates = [
		'list_akt_created_at',
		'list_akt_updated_at',
		'list_akt_deleted_at'
	];

	protected $fillable = [
		'list_akt_nama',
		'list_akt_m_rekening_id',
		'list_akt_created_by',
		'list_akt_updated_by',
		'list_akt_deleted_by',
		'list_akt_created_at',
		'list_akt_updated_at',
		'list_akt_deleted_at'
	];
}
