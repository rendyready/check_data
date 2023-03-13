<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbTransTest
 * 
 * @property int $tb_trans_test_id
 * @property string $tb_trans_test_rekap_beli_code
 * @property int $tb_trans_test_m_produk_id
 * @property string $tb_trans_test_m_produk_code
 * @property string $tb_trans_test_m_produk_nama
 * @property string $tb_trans_test_catatan
 * @property float $tb_trans_test_qty
 * @property float $tb_trans_test_harga
 * @property float|null $tb_trans_test_disc
 * @property float|null $tb_trans_test_discrp
 * @property float $tb_trans_test_subtot
 * @property string|null $tb_trans_test_terima
 * @property string|null $tb_trans_test_satuan_terima
 * @property int $tb_trans_test_waroeng_id
 * @property string $tb_trans_test_waroeng
 * @property int $tb_trans_test_created_by
 * @property int|null $tb_trans_test_updated_by
 * @property int|null $tb_trans_test_deleted_by
 * @property Carbon $tb_trans_test_created_at
 * @property Carbon|null $tb_trans_test_updated_at
 * @property Carbon|null $tb_trans_test_deleted_at
 *
 * @package App\Models
 */
class TbTransTest extends Model
{
	protected $table = 'tb_trans_test';
	protected $primaryKey = 'tb_trans_test_id';
	public $timestamps = false;

	protected $casts = [
		'tb_trans_test_m_produk_id' => 'int',
		'tb_trans_test_qty' => 'float',
		'tb_trans_test_harga' => 'float',
		'tb_trans_test_disc' => 'float',
		'tb_trans_test_discrp' => 'float',
		'tb_trans_test_subtot' => 'float',
		'tb_trans_test_waroeng_id' => 'int',
		'tb_trans_test_created_by' => 'int',
		'tb_trans_test_updated_by' => 'int',
		'tb_trans_test_deleted_by' => 'int'
	];

	protected $dates = [
		'tb_trans_test_created_at',
		'tb_trans_test_updated_at',
		'tb_trans_test_deleted_at'
	];

	protected $fillable = [
		'tb_trans_test_rekap_beli_code',
		'tb_trans_test_m_produk_id',
		'tb_trans_test_m_produk_code',
		'tb_trans_test_m_produk_nama',
		'tb_trans_test_catatan',
		'tb_trans_test_qty',
		'tb_trans_test_harga',
		'tb_trans_test_disc',
		'tb_trans_test_discrp',
		'tb_trans_test_subtot',
		'tb_trans_test_terima',
		'tb_trans_test_satuan_terima',
		'tb_trans_test_waroeng_id',
		'tb_trans_test_waroeng',
		'tb_trans_test_created_by',
		'tb_trans_test_updated_by',
		'tb_trans_test_deleted_by',
		'tb_trans_test_created_at',
		'tb_trans_test_updated_at',
		'tb_trans_test_deleted_at'
	];
}
