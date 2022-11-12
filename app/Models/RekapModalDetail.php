<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapModalDetail
 * 
 * @property int $rekap_modal_detail_id
 * @property int|null $rekap_modal_detail_qty
 * @property int $rekap_modal_detail_m_modal_tipe_id
 * @property int $rekap_modal_detail_m_modal_id
 * @property string|null $rekap_modal_detail_status_sync
 * @property string $rekap_modal_detail_created_by
 * @property string|null $rekap_modal_detail_updated_by
 * @property Carbon $rekap_modal_detail_created_at
 * @property Carbon|null $rekap_modal_detail_updated_at
 * @property Carbon|null $rekap_modal_detail_deleted_at
 *
 * @package App\Models
 */
class RekapModalDetail extends Model
{
	protected $table = 'rekap_modal_detail';
	protected $primaryKey = 'rekap_modal_detail_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_modal_detail_qty' => 'int',
		'rekap_modal_detail_m_modal_tipe_id' => 'int',
		'rekap_modal_detail_m_modal_id' => 'int'
	];

	protected $dates = [
		'rekap_modal_detail_created_at',
		'rekap_modal_detail_updated_at',
		'rekap_modal_detail_deleted_at'
	];

	protected $fillable = [
		'rekap_modal_detail_qty',
		'rekap_modal_detail_m_modal_tipe_id',
		'rekap_modal_detail_m_modal_id',
		'rekap_modal_detail_status_sync',
		'rekap_modal_detail_created_by',
		'rekap_modal_detail_updated_by',
		'rekap_modal_detail_created_at',
		'rekap_modal_detail_updated_at',
		'rekap_modal_detail_deleted_at'
	];
}
