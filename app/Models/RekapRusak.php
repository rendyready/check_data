<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapRusak
 * 
 * @property int $rekap_rusak_id
 * @property string $rekap_rusak_code
 * @property Carbon $rekap_rusak_tgl
 * @property int $rekap_rusak_m_w_id
 * @property int $rekap_rusak_created_by
 * @property int|null $rekap_rusak_updated_by
 * @property int|null $rekap_rusak_deleted_by
 * @property Carbon $rekap_rusak_created_at
 * @property Carbon|null $rekap_rusak_updated_at
 * @property Carbon|null $rekap_rusak_deleted_at
 *
 * @package App\Models
 */
class RekapRusak extends Model
{
	protected $table = 'rekap_rusak';
	protected $primaryKey = 'rekap_rusak_id';
	public $timestamps = false;

	protected $casts = [
		'rekap_rusak_m_w_id' => 'int',
		'rekap_rusak_created_by' => 'int',
		'rekap_rusak_updated_by' => 'int',
		'rekap_rusak_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_rusak_tgl',
		'rekap_rusak_created_at',
		'rekap_rusak_updated_at',
		'rekap_rusak_deleted_at'
	];

	protected $fillable = [
		'rekap_rusak_code',
		'rekap_rusak_tgl',
		'rekap_rusak_m_w_id',
		'rekap_rusak_created_by',
		'rekap_rusak_updated_by',
		'rekap_rusak_deleted_by',
		'rekap_rusak_created_at',
		'rekap_rusak_updated_at',
		'rekap_rusak_deleted_at'
	];
}
