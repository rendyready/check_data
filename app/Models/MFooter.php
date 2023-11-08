<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MFooter
 * 
 * @property int $id
 * @property int $m_footer_id
 * @property int $m_footer_m_w_id
 * @property string $m_footer_value
 * @property int $m_footer_priority
 * @property int $m_footer_created_by
 * @property int|null $m_footer_updated_by
 * @property int|null $m_footer_deleted_by
 * @property Carbon $m_footer_created_at
 * @property Carbon|null $m_footer_updated_at
 * @property Carbon|null $m_footer_deleted_at
 * @property string $m_footer_status_sync
 *
 * @package App\Models
 */
class MFooter extends Model
{
	protected $table = 'm_footer';
	public $timestamps = false;

	protected $casts = [
		'm_footer_id' => 'int',
		'm_footer_m_w_id' => 'int',
		'm_footer_priority' => 'int',
		'm_footer_created_by' => 'int',
		'm_footer_updated_by' => 'int',
		'm_footer_deleted_by' => 'int',
		'm_footer_created_at' => 'datetime',
		'm_footer_updated_at' => 'datetime',
		'm_footer_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_footer_id',
		'm_footer_m_w_id',
		'm_footer_value',
		'm_footer_priority',
		'm_footer_created_by',
		'm_footer_updated_by',
		'm_footer_deleted_by',
		'm_footer_created_at',
		'm_footer_updated_at',
		'm_footer_deleted_at',
		'm_footer_status_sync'
	];
}
