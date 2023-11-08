<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJurnalBank
 * 
 * @property int $m_jurnal_bank_id
 * @property string $m_jurnal_bank_m_waroeng_id
 * @property string $m_jurnal_bank_m_rekening_no_akun
 * @property string $m_jurnal_bank_m_rekening_nama
 * @property Carbon $m_jurnal_bank_tanggal
 * @property string $m_jurnal_bank_particul
 * @property float $m_jurnal_bank_saldo
 * @property string $m_jurnal_bank_no_bukti
 * @property string $m_jurnal_bank_kas
 * @property string $m_jurnal_bank_user
 * @property int $m_jurnal_bank_created_by
 * @property int|null $m_jurnal_bank_updated_by
 * @property int|null $m_jurnal_bank_deleted_by
 * @property Carbon $m_jurnal_bank_created_at
 * @property Carbon|null $m_jurnal_bank_updated_at
 * @property Carbon|null $m_jurnal_bank_deleted_at
 *
 * @package App\Models
 */
class MJurnalBank extends Model
{
	protected $table = 'm_jurnal_bank';
	protected $primaryKey = 'm_jurnal_bank_id';
	public $timestamps = false;

	protected $casts = [
		'm_jurnal_bank_tanggal' => 'datetime',
		'm_jurnal_bank_saldo' => 'float',
		'm_jurnal_bank_created_by' => 'int',
		'm_jurnal_bank_updated_by' => 'int',
		'm_jurnal_bank_deleted_by' => 'int',
		'm_jurnal_bank_created_at' => 'datetime',
		'm_jurnal_bank_updated_at' => 'datetime',
		'm_jurnal_bank_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_jurnal_bank_m_waroeng_id',
		'm_jurnal_bank_m_rekening_no_akun',
		'm_jurnal_bank_m_rekening_nama',
		'm_jurnal_bank_tanggal',
		'm_jurnal_bank_particul',
		'm_jurnal_bank_saldo',
		'm_jurnal_bank_no_bukti',
		'm_jurnal_bank_kas',
		'm_jurnal_bank_user',
		'm_jurnal_bank_created_by',
		'm_jurnal_bank_updated_by',
		'm_jurnal_bank_deleted_by',
		'm_jurnal_bank_created_at',
		'm_jurnal_bank_updated_at',
		'm_jurnal_bank_deleted_at'
	];
}
