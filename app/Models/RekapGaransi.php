<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapGaransi
 * 
 * @property int $id
 * @property string $rekap_garansi_id
 * @property string $rekap_garansi_r_t_id
 * @property int $rekap_garansi_m_produk_id
 * @property string|null $rekap_garansi_m_produk_code
 * @property string|null $rekap_garansi_m_produk_nama
 * @property float $rekap_garansi_reguler_price
 * @property float $rekap_garansi_price
 * @property int $rekap_garansi_qty
 * @property float $rekap_garansi_nominal
 * @property string $rekap_garansi_keterangan
 * @property string $rekap_garansi_action
 * @property string $rekap_garansi_status_sync
 * @property int $rekap_garansi_created_by
 * @property int|null $rekap_garansi_updated_by
 * @property int|null $rekap_garansi_deleted_by
 * @property Carbon $rekap_garansi_created_at
 * @property Carbon|null $rekap_garansi_updated_at
 * @property Carbon|null $rekap_garansi_deleted_at
 *
 * @package App\Models
 */
class RekapGaransi extends Model
{
	protected $table = 'rekap_garansi';
	public $timestamps = false;

	protected $casts = [
		'rekap_garansi_m_produk_id' => 'int',
		'rekap_garansi_reguler_price' => 'float',
		'rekap_garansi_price' => 'float',
		'rekap_garansi_qty' => 'int',
		'rekap_garansi_nominal' => 'float',
		'rekap_garansi_created_by' => 'int',
		'rekap_garansi_updated_by' => 'int',
		'rekap_garansi_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_garansi_created_at',
		'rekap_garansi_updated_at',
		'rekap_garansi_deleted_at'
	];

	protected $fillable = [
		'rekap_garansi_id',
		'rekap_garansi_r_t_id',
		'rekap_garansi_m_produk_id',
		'rekap_garansi_m_produk_code',
		'rekap_garansi_m_produk_nama',
		'rekap_garansi_reguler_price',
		'rekap_garansi_price',
		'rekap_garansi_qty',
		'rekap_garansi_nominal',
		'rekap_garansi_keterangan',
		'rekap_garansi_action',
		'rekap_garansi_status_sync',
		'rekap_garansi_created_by',
		'rekap_garansi_updated_by',
		'rekap_garansi_deleted_by',
		'rekap_garansi_created_at',
		'rekap_garansi_updated_at',
		'rekap_garansi_deleted_at'
	];
}
