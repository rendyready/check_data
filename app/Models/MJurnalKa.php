<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJurnalKa
 * 
 * @property int $m_jurnal_kas_id
 * @property int $m_jurnal_kas_m_waroeng_id
 * @property string $m_jurnal_kas_m_rekening_no_akun
 * @property string $m_jurnal_kas_m_rekening_nama
 * @property Carbon $m_jurnal_kas_tanggal
 * @property string $m_jurnal_kas_particul
 * @property float $m_jurnal_kas_saldo
 * @property string $m_jurnal_kas_no_bukti
 * @property string $m_jurnal_kas
 * @property string $m_jurnal_kas_user
 * @property int $m_jurnal_kas_created_by
 * @property int|null $m_jurnal_kas_updated_by
 * @property int|null $m_jurnal_kas_deleted_by
 * @property Carbon $m_jurnal_kas_created_at
 * @property Carbon|null $m_jurnal_kas_updated_at
 * @property Carbon|null $m_jurnal_kas_deleted_at
 *
 * @package App\Models
 */
class MJurnalKa extends Model
{
	protected $table = 'm_jurnal_kas';
	protected $primaryKey = 'm_jurnal_kas_id';
	public $timestamps = false;

	protected $casts = [
		'm_jurnal_kas_m_waroeng_id' => 'int',
		'm_jurnal_kas_saldo' => 'float',
		'm_jurnal_kas_created_by' => 'int',
		'm_jurnal_kas_updated_by' => 'int',
		'm_jurnal_kas_deleted_by' => 'int'
	];

	protected $dates = [
		'm_jurnal_kas_tanggal',
		'm_jurnal_kas_created_at',
		'm_jurnal_kas_updated_at',
		'm_jurnal_kas_deleted_at'
	];

	protected $fillable = [
		'm_jurnal_kas_m_waroeng_id',
		'm_jurnal_kas_m_rekening_no_akun',
		'm_jurnal_kas_m_rekening_nama',
		'm_jurnal_kas_tanggal',
		'm_jurnal_kas_particul',
		'm_jurnal_kas_saldo',
		'm_jurnal_kas_no_bukti',
		'm_jurnal_kas',
		'm_jurnal_kas_user',
		'm_jurnal_kas_created_by',
		'm_jurnal_kas_updated_by',
		'm_jurnal_kas_deleted_by',
		'm_jurnal_kas_created_at',
		'm_jurnal_kas_updated_at',
		'm_jurnal_kas_deleted_at'
	];
}
