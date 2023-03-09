<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MSupplier
 * 
 * @property int $m_supplier_id
 * @property string $m_supplier_code
 * @property string $m_supplier_nama
 * @property string $m_supplier_jth_tempo
 * @property string $m_supplier_alamat
 * @property string $m_supplier_kota
 * @property string $m_supplier_telp
 * @property string $m_supplier_ket
 * @property string $m_supplier_rek
 * @property string $m_supplier_rek_nama
 * @property string $m_supplier_bank_nama
 * @property float $m_supplier_saldo_awal
 * @property int $m_supplier_created_by
 * @property int|null $m_supplier_updated_by
 * @property int|null $m_supplier_deleted_by
 * @property Carbon $m_supplier_created_at
 * @property Carbon|null $m_supplier_updated_at
 * @property Carbon|null $m_supplier_deleted_at
 *
 * @package App\Models
 */
class MSupplier extends Model
{
	protected $table = 'm_supplier';
	protected $primaryKey = 'm_supplier_id';
	public $timestamps = false;

	protected $casts = [
		'm_supplier_saldo_awal' => 'float',
		'm_supplier_created_by' => 'int',
		'm_supplier_updated_by' => 'int',
		'm_supplier_deleted_by' => 'int'
	];

	protected $dates = [
		'm_supplier_created_at',
		'm_supplier_updated_at',
		'm_supplier_deleted_at'
	];

	protected $fillable = [
		'm_supplier_code',
		'm_supplier_nama',
		'm_supplier_jth_tempo',
		'm_supplier_alamat',
		'm_supplier_kota',
		'm_supplier_telp',
		'm_supplier_ket',
		'm_supplier_rek',
		'm_supplier_rek_nama',
		'm_supplier_bank_nama',
		'm_supplier_saldo_awal',
		'm_supplier_created_by',
		'm_supplier_updated_by',
		'm_supplier_deleted_by',
		'm_supplier_created_at',
		'm_supplier_updated_at',
		'm_supplier_deleted_at'
	];
}
