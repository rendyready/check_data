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
 * @property string $m_w_nama
 * @property int $m_w_m_area_id
 * @property int $m_w_m_w_jenis_id
 * @property string $m_w_status
 * @property string $m_w_alamat
 * @property int $m_w_m_jenis_nota_id
 * @property int $m_w_m_pajak_id
 * @property int $m_w_m_modal_tipe_id
 * @property int $m_w_m_sc_id
 * @property int $m_w_decimal
 * @property string $m_w_pembulatan
 * @property string $m_w_currency
 * @property float $m_w_grab
 * @property float $m_w_gojek
 * @property string $m_menu_profit
 * @property int $m_w_created_by
 * @property Carbon $m_w_created_at
 * @property int|null $m_w_updated_by
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
		'm_w_m_area_id' => 'int',
		'm_w_m_w_jenis_id' => 'int',
		'm_w_m_jenis_nota_id' => 'int',
		'm_w_m_pajak_id' => 'int',
		'm_w_m_modal_tipe_id' => 'int',
		'm_w_m_sc_id' => 'int',
		'm_w_decimal' => 'int',
		'm_w_grab' => 'float',
		'm_w_gojek' => 'float',
		'm_w_created_by' => 'int',
		'm_w_updated_by' => 'int'
	];

	protected $dates = [
		'm_w_created_at',
		'm_w_updated_at',
		'm_w_deleted_at'
	];

	protected $fillable = [
		'm_w_nama',
		'm_w_m_area_id',
		'm_w_m_w_jenis_id',
		'm_w_status',
		'm_w_alamat',
		'm_w_m_jenis_nota_id',
		'm_w_m_pajak_id',
		'm_w_m_modal_tipe_id',
		'm_w_m_sc_id',
		'm_w_decimal',
		'm_w_pembulatan',
		'm_w_currency',
		'm_w_grab',
		'm_w_gojek',
		'm_menu_profit',
		'm_w_created_by',
		'm_w_created_at',
		'm_w_updated_by',
		'm_w_updated_at',
		'm_w_deleted_at'
	];
}
