<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapMember
 * 
 * @property int $id
 * @property string $rekap_member_id
 * @property string $rekap_member_phone
 * @property string $rekap_member_name
 * @property string $rekap_member_status_sync
 * @property int $rekap_member_created_by
 * @property int|null $rekap_member_updated_by
 * @property int|null $rekap_member_deleted_by
 * @property Carbon $rekap_member_created_at
 * @property Carbon|null $rekap_member_updated_at
 * @property Carbon|null $rekap_member_deleted_at
 *
 * @package App\Models
 */
class RekapMember extends Model
{
	protected $table = 'rekap_member';
	public $timestamps = false;

	protected $casts = [
		'rekap_member_created_by' => 'int',
		'rekap_member_updated_by' => 'int',
		'rekap_member_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_member_created_at',
		'rekap_member_updated_at',
		'rekap_member_deleted_at'
	];

	protected $fillable = [
		'rekap_member_id',
		'rekap_member_phone',
		'rekap_member_name',
		'rekap_member_status_sync',
		'rekap_member_created_by',
		'rekap_member_updated_by',
		'rekap_member_deleted_by',
		'rekap_member_created_at',
		'rekap_member_updated_at',
		'rekap_member_deleted_at'
	];
}
