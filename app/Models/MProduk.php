<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MProduk
 * 
 * @property int $m_produk_id
 * @property string|null $m_produk_code
 * @property string $m_produk_nama
 * @property string|null $m_produk_urut
 * @property string|null $m_produk_cr
 * @property string $m_produk_status
 * @property string $m_produk_tax
 * @property string $m_produk_sc
 * @property int $m_produk_m_jenis_produk_id
 * @property int|null $m_produk_m_plot_produksi_id
 * @property int|null $m_produk_m_klasifikasi_produk_id
 * @property string $m_produk_jual
 * @property string $m_produk_scp
 * @property string $m_produk_hpp
 * @property int $m_produk_created_by
 * @property Carbon $m_produk_created_at
 * @property int|null $m_produk_updated_by
 * @property Carbon|null $m_produk_updated_at
 * @property Carbon|null $m_produk_deleted_at
 *
 * @package App\Models
 */
class MProduk extends Model
{
	protected $table = 'm_produk';
	protected $primaryKey = 'm_produk_id';
	public $timestamps = false;

	protected $casts = [
		'm_produk_m_jenis_produk_id' => 'int',
		'm_produk_m_plot_produksi_id' => 'int',
		'm_produk_m_klasifikasi_produk_id' => 'int',
		'm_produk_created_by' => 'int',
		'm_produk_updated_by' => 'int'
	];

	protected $dates = [
		'm_produk_created_at',
		'm_produk_updated_at',
		'm_produk_deleted_at'
	];

	protected $fillable = [
		'm_produk_code',
		'm_produk_nama',
		'm_produk_urut',
		'm_produk_cr',
		'm_produk_status',
		'm_produk_tax',
		'm_produk_sc',
		'm_produk_m_jenis_produk_id',
		'm_produk_m_plot_produksi_id',
		'm_produk_m_klasifikasi_produk_id',
		'm_produk_jual',
		'm_produk_scp',
		'm_produk_hpp',
		'm_produk_created_by',
		'm_produk_created_at',
		'm_produk_updated_by',
		'm_produk_updated_at',
		'm_produk_deleted_at'
	];
}
