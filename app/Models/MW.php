<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MW
 * 
 * @property int $id
 * @property int $m_w_id
 * @property string $m_w_nama
 * @property string $m_w_code
 * @property int $m_w_m_area_id
 * @property int $m_w_m_w_jenis_id
 * @property string $m_w_status
 * @property string $m_w_alamat
 * @property string $m_w_m_kode_nota
 * @property int $m_w_m_pajak_id
 * @property int $m_w_m_modal_tipe_id
 * @property int $m_w_m_sc_id
 * @property int $m_w_decimal
 * @property string $m_w_pembulatan
 * @property string $m_w_currency
 * @property int $m_w_created_by
 * @property Carbon $m_w_created_at
 * @property int|null $m_w_updated_by
 * @property int|null $m_w_deleted_by
 * @property Carbon|null $m_w_updated_at
 * @property Carbon|null $m_w_deleted_at
 *
 * @package App\Models
 */
class MW extends Model
{
	protected $table = 'm_w';
	public $timestamps = false;

	protected $casts = [
		'm_w_id' => 'int',
		'm_w_m_area_id' => 'int',
		'm_w_m_w_jenis_id' => 'int',
		'm_w_m_pajak_id' => 'int',
		'm_w_m_modal_tipe_id' => 'int',
		'm_w_m_sc_id' => 'int',
		'm_w_decimal' => 'int',
		'm_w_created_by' => 'int',
		'm_w_updated_by' => 'int',
		'm_w_deleted_by' => 'int'
	];

	protected $dates = [
		'm_w_created_at',
		'm_w_updated_at',
		'm_w_deleted_at'
	];

	protected $fillable = [
		'm_w_id',
		'm_w_nama',
		'm_w_code',
		'm_w_m_area_id',
		'm_w_m_w_jenis_id',
		'm_w_status',
		'm_w_alamat',
		'm_w_m_kode_nota',
		'm_w_m_pajak_id',
		'm_w_m_modal_tipe_id',
		'm_w_m_sc_id',
		'm_w_decimal',
		'm_w_pembulatan',
		'm_w_currency',
		'm_w_created_by',
		'm_w_created_at',
		'm_w_updated_by',
		'm_w_deleted_by',
		'm_w_updated_at',
		'm_w_deleted_at'
	];
}
