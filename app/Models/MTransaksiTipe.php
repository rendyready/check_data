<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MTransaksiTipe
 * 
 * @property int $id
 * @property int $m_t_t_id
 * @property string $m_t_t_name
 * @property float $m_t_t_profit_price
 * @property float $m_t_t_profit_in
 * @property float $m_t_t_profit_out
 * @property string $m_t_t_group
 * @property int $m_t_t_created_by
 * @property int|null $m_t_t_updated_by
 * @property int|null $m_t_t_deleted_by
 * @property Carbon $m_t_t_created_at
 * @property Carbon|null $m_t_t_updated_at
 * @property Carbon|null $m_t_t_deleted_at
 *
 * @package App\Models
 */
class MTransaksiTipe extends Model
{
	protected $table = 'm_transaksi_tipe';
	public $timestamps = false;

	protected $casts = [
		'm_t_t_id' => 'int',
		'm_t_t_profit_price' => 'float',
		'm_t_t_profit_in' => 'float',
		'm_t_t_profit_out' => 'float',
		'm_t_t_created_by' => 'int',
		'm_t_t_updated_by' => 'int',
		'm_t_t_deleted_by' => 'int'
	];

	protected $dates = [
		'm_t_t_created_at',
		'm_t_t_updated_at',
		'm_t_t_deleted_at'
	];

	protected $fillable = [
		'm_t_t_id',
		'm_t_t_name',
		'm_t_t_profit_price',
		'm_t_t_profit_in',
		'm_t_t_profit_out',
		'm_t_t_group',
		'm_t_t_created_by',
		'm_t_t_updated_by',
		'm_t_t_deleted_by',
		'm_t_t_created_at',
		'm_t_t_updated_at',
		'm_t_t_deleted_at'
	];
}
