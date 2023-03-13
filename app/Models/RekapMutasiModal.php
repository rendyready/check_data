<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapMutasiModal
 * 
 * @property int $id
 * @property string $r_m_m_id
 * @property string $r_m_m_rekap_modal_id
 * @property Carbon $r_m_m_tanggal
 * @property time without time zone $r_m_m_jam
 * @property float $r_m_m_debit
 * @property float $r_m_m_kredit
 * @property string $r_m_m_keterangan
 * @property int $r_m_m_m_w_id
 * @property string|null $r_m_m_m_w_code
 * @property string|null $r_m_m_m_w_nama
 * @property int $r_m_m_m_area_id
 * @property string|null $r_m_m_m_area_code
 * @property string|null $r_m_m_m_area_nama
 * @property string $r_m_m_status_sync
 * @property int $r_m_m_created_by
 * @property int|null $r_m_m_updated_by
 * @property int|null $r_m_m_deleted_by
 * @property Carbon $r_m_m_created_at
 * @property Carbon|null $r_m_m_updated_at
 * @property Carbon|null $r_m_m_deleted_at
 *
 * @package App\Models
 */
class RekapMutasiModal extends Model
{
	protected $table = 'rekap_mutasi_modal';
	public $timestamps = false;

	protected $casts = [
		'r_m_m_jam' => 'time without time zone',
		'r_m_m_debit' => 'float',
		'r_m_m_kredit' => 'float',
		'r_m_m_m_w_id' => 'int',
		'r_m_m_m_area_id' => 'int',
		'r_m_m_created_by' => 'int',
		'r_m_m_updated_by' => 'int',
		'r_m_m_deleted_by' => 'int'
	];

	protected $dates = [
		'r_m_m_tanggal',
		'r_m_m_created_at',
		'r_m_m_updated_at',
		'r_m_m_deleted_at'
	];

	protected $fillable = [
		'r_m_m_id',
		'r_m_m_rekap_modal_id',
		'r_m_m_tanggal',
		'r_m_m_jam',
		'r_m_m_debit',
		'r_m_m_kredit',
		'r_m_m_keterangan',
		'r_m_m_m_w_id',
		'r_m_m_m_w_code',
		'r_m_m_m_w_nama',
		'r_m_m_m_area_id',
		'r_m_m_m_area_code',
		'r_m_m_m_area_nama',
		'r_m_m_status_sync',
		'r_m_m_created_by',
		'r_m_m_updated_by',
		'r_m_m_deleted_by',
		'r_m_m_created_at',
		'r_m_m_updated_at',
		'r_m_m_deleted_at'
	];
}
