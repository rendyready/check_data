<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MResepDetail
 * 
 * @property int $id
 * @property string $m_resep_detail_id
 * @property string $m_resep_detail_m_resep_code
 * @property string $m_resep_detail_bb_code
 * @property string $m_resep_detail_m_produk_nama
 * @property float $m_resep_detail_bb_qty
 * @property string $m_resep_detail_satuan
 * @property string|null $m_resep_detail_standar_porsi
 * @property int $m_resep_detail_m_satuan_id
 * @property string|null $m_resep_detail_ket
 * @property int $m_resep_detail_created_by
 * @property int|null $m_resep_detail_updated_by
 * @property int|null $m_resep_detail_deleted_by
 * @property Carbon $m_resep_detail_created_at
 * @property Carbon|null $m_resep_detail_updated_at
 * @property Carbon|null $m_resep_detail_deleted_at
 *
 * @package App\Models
 */
class MResepDetail extends Model
{
	protected $table = 'm_resep_detail';
	public $timestamps = false;

	protected $casts = [
		'm_resep_detail_bb_qty' => 'float',
		'm_resep_detail_m_satuan_id' => 'int',
		'm_resep_detail_created_by' => 'int',
		'm_resep_detail_updated_by' => 'int',
		'm_resep_detail_deleted_by' => 'int',
		'm_resep_detail_created_at' => 'datetime',
		'm_resep_detail_updated_at' => 'datetime',
		'm_resep_detail_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_resep_detail_id',
		'm_resep_detail_m_resep_code',
		'm_resep_detail_bb_code',
		'm_resep_detail_m_produk_nama',
		'm_resep_detail_bb_qty',
		'm_resep_detail_satuan',
		'm_resep_detail_standar_porsi',
		'm_resep_detail_m_satuan_id',
		'm_resep_detail_ket',
		'm_resep_detail_created_by',
		'm_resep_detail_updated_by',
		'm_resep_detail_deleted_by',
		'm_resep_detail_created_at',
		'm_resep_detail_updated_at',
		'm_resep_detail_deleted_at'
	];
}
