<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPaymentTransaksi
 * 
 * @property int $r_p_t_id
 * @property int $r_p_t_r_t_id
 * @property string $r_p_t_type
 * @property float $r_p_t_nominal
 * @property string|null $r_p_t_vendor
 * @property string $r_p_t_status_sync
 * @property int $r_p_t_created_by
 * @property int|null $r_p_t_updated_by
 * @property Carbon $r_p_t_created_at
 * @property Carbon|null $r_p_t_updated_at
 * @property Carbon|null $r_p_t_deleted_at
 *
 * @package App\Models
 */
class RekapPaymentTransaksi extends Model
{
	protected $table = 'rekap_payment_transaksi';
	protected $primaryKey = 'r_p_t_id';
	public $timestamps = false;

	protected $casts = [
		'r_p_t_r_t_id' => 'int',
		'r_p_t_nominal' => 'float',
		'r_p_t_created_by' => 'int',
		'r_p_t_updated_by' => 'int'
	];

	protected $dates = [
		'r_p_t_created_at',
		'r_p_t_updated_at',
		'r_p_t_deleted_at'
	];

	protected $fillable = [
		'r_p_t_r_t_id',
		'r_p_t_type',
		'r_p_t_nominal',
		'r_p_t_vendor',
		'r_p_t_status_sync',
		'r_p_t_created_by',
		'r_p_t_updated_by',
		'r_p_t_created_at',
		'r_p_t_updated_at',
		'r_p_t_deleted_at'
	];
}
