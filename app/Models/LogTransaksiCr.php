<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogTransaksiCr
 * 
 * @property int $id
 * @property int $log_transaksi_cr_id
 * @property string $log_transaksi_cr_r_t_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LogTransaksiCr extends Model
{
	protected $table = 'log_transaksi_cr';

	protected $casts = [
		'log_transaksi_cr_id' => 'int'
	];

	protected $fillable = [
		'log_transaksi_cr_id',
		'log_transaksi_cr_r_t_id'
	];
}
