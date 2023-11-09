<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MJurnalUmum
 * 
 * @property int $m_jurnal_umum_id
 * @property string $m_jurnal_umum_m_waroeng_id
 * @property string $m_jurnal_umum_m_rekening_no_akun
 * @property string $m_jurnal_umum_m_rekening_nama
 * @property Carbon $m_jurnal_umum_tanggal
 * @property string $m_jurnal_umum_particul
 * @property float $m_jurnal_umum_debit
 * @property float $m_jurnal_umum_kredit
 * @property string $m_jurnal_umum_user
 * @property string $m_jurnal_umum_no_bukti
 * @property int $m_jurnal_umum_created_by
 * @property int|null $m_jurnal_umum_updated_by
 * @property int|null $m_jurnal_umum_deleted_by
 * @property Carbon $m_jurnal_umum_created_at
 * @property Carbon|null $m_jurnal_umum_updated_at
 * @property Carbon|null $m_jurnal_umum_deleted_at
 *
 * @package App\Models
 */
class MJurnalUmum extends Model
{
	protected $table = 'm_jurnal_umum';
	protected $primaryKey = 'm_jurnal_umum_id';
	public $timestamps = false;

	protected $casts = [
		'm_jurnal_umum_tanggal' => 'datetime',
		'm_jurnal_umum_debit' => 'float',
		'm_jurnal_umum_kredit' => 'float',
		'm_jurnal_umum_created_by' => 'int',
		'm_jurnal_umum_updated_by' => 'int',
		'm_jurnal_umum_deleted_by' => 'int',
		'm_jurnal_umum_created_at' => 'datetime',
		'm_jurnal_umum_updated_at' => 'datetime',
		'm_jurnal_umum_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_jurnal_umum_m_waroeng_id',
		'm_jurnal_umum_m_rekening_no_akun',
		'm_jurnal_umum_m_rekening_nama',
		'm_jurnal_umum_tanggal',
		'm_jurnal_umum_particul',
		'm_jurnal_umum_debit',
		'm_jurnal_umum_kredit',
		'm_jurnal_umum_user',
		'm_jurnal_umum_no_bukti',
		'm_jurnal_umum_created_by',
		'm_jurnal_umum_updated_by',
		'm_jurnal_umum_deleted_by',
		'm_jurnal_umum_created_at',
		'm_jurnal_umum_updated_at',
		'm_jurnal_umum_deleted_at'
	];
}
