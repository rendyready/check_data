<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapModal
 * 
 * @property int $rekap_modal_id
 * @property int $rekap_modal_m_w_id
 * @property int $rekap_modal_shift
 * @property Carbon $rekap_modal_tanggal
 * @property float $rekap_modal_nominal
 * @property bool $rekap_modal_status
 * @property string|null $rekap_modal_status_sync
 * @property int $rekap_modal_created_by
 * @property int|null $rekap_modal_updated_by
 * @property Carbon $rekap_modal_created_at
 * @property Carbon|null $rekap_modal_updated_at
 * @property Carbon|null $rekap_modal_deleted_at
 *
 * @package App\Models
 */
class RekapModal extends Model
{
	protected $table = 'rekap_modal';
	protected $primaryKey = 'rekap_modal_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_modal_m_w_id' => 'int',
		'rekap_modal_shift' => 'int',
		'rekap_modal_nominal' => 'float',
		'rekap_modal_status' => 'bool',
		'rekap_modal_created_by' => 'int',
		'rekap_modal_updated_by' => 'int'
	];

	protected $dates = [
		'rekap_modal_tanggal',
		'rekap_modal_created_at',
		'rekap_modal_updated_at',
		'rekap_modal_deleted_at'
	];

	protected $fillable = [
		'rekap_modal_m_w_id',
		'rekap_modal_shift',
		'rekap_modal_tanggal',
		'rekap_modal_nominal',
		'rekap_modal_status',
		'rekap_modal_status_sync',
		'rekap_modal_created_by',
		'rekap_modal_updated_by',
		'rekap_modal_created_at',
		'rekap_modal_updated_at',
		'rekap_modal_deleted_at'
	];
}
