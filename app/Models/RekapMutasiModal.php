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
 * @property int $r_m_m_id
 * @property Carbon $r_m_m_tanggal
 * @property int $r_m_m_shift
 * @property time without time zone $r_m_m_jam
 * @property string $r_m_m_pengguna
 * @property string $r_m_m_pengguna_nama
 * @property float $r_m_m_debit
 * @property float $r_m_m_kredit
 * @property string $r_m_m_keterangan
 * @property int $r_m_m_m_w_id
 * @property string $r_m_m_m_w_nama
 * @property int $r_m_m_m_area_id
 * @property string $r_m_m_m_area_nama
 * @property int $r_m_m_kasir_id
 * @property string $r_m_m_kasir_nama
 * @property string $r_m_m_status_sync
 * @property int $r_m_m_created_by
 * @property int|null $r_m_m_updated_by
 * @property Carbon $r_m_m_created_at
 * @property Carbon|null $r_m_m_updated_at
 * @property Carbon|null $r_m_m_deleted_at
 *
 * @package App\Models
 */
class RekapMutasiModal extends Model
{
	protected $table = 'rekap_mutasi_modal';
	protected $primaryKey = 'r_m_m_id';
	public $timestamps = false;

	protected $casts = [
		'r_m_m_shift' => 'int',
		'r_m_m_jam' => 'time without time zone',
		'r_m_m_debit' => 'float',
		'r_m_m_kredit' => 'float',
		'r_m_m_m_w_id' => 'int',
		'r_m_m_m_area_id' => 'int',
		'r_m_m_kasir_id' => 'int',
		'r_m_m_created_by' => 'int',
		'r_m_m_updated_by' => 'int'
	];

	protected $dates = [
		'r_m_m_tanggal',
		'r_m_m_created_at',
		'r_m_m_updated_at',
		'r_m_m_deleted_at'
	];

	protected $fillable = [
		'r_m_m_tanggal',
		'r_m_m_shift',
		'r_m_m_jam',
		'r_m_m_pengguna',
		'r_m_m_pengguna_nama',
		'r_m_m_debit',
		'r_m_m_kredit',
		'r_m_m_keterangan',
		'r_m_m_m_w_id',
		'r_m_m_m_w_nama',
		'r_m_m_m_area_id',
		'r_m_m_m_area_nama',
		'r_m_m_kasir_id',
		'r_m_m_kasir_nama',
		'r_m_m_status_sync',
		'r_m_m_created_by',
		'r_m_m_updated_by',
		'r_m_m_created_at',
		'r_m_m_updated_at',
		'r_m_m_deleted_at'
	];
}