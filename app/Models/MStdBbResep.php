<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MStdBbResep
 * 
 * @property int $id
 * @property string $m_std_bb_resep_id
 * @property string $m_std_bb_resep_m_produk_code
 * @property float $m_std_bb_resep_qty
 * @property string $m_std_bb_resep_porsi
 * @property int $m_std_bb_resep_created_by
 * @property int|null $m_std_bb_resep_updated_by
 * @property int|null $m_std_bb_resep_deleted_by
 * @property Carbon $m_std_bb_resep_created_at
 * @property Carbon|null $m_std_bb_resep_updated_at
 * @property Carbon|null $m_std_bb_resep_deleted_at
 *
 * @package App\Models
 */
class MStdBbResep extends Model
{
	protected $table = 'm_std_bb_resep';
	public $timestamps = false;

	protected $casts = [
		'm_std_bb_resep_qty' => 'float',
		'm_std_bb_resep_created_by' => 'int',
		'm_std_bb_resep_updated_by' => 'int',
		'm_std_bb_resep_deleted_by' => 'int',
		'm_std_bb_resep_created_at' => 'datetime',
		'm_std_bb_resep_updated_at' => 'datetime',
		'm_std_bb_resep_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_std_bb_resep_id',
		'm_std_bb_resep_m_produk_code',
		'm_std_bb_resep_qty',
		'm_std_bb_resep_porsi',
		'm_std_bb_resep_created_by',
		'm_std_bb_resep_updated_by',
		'm_std_bb_resep_deleted_by',
		'm_std_bb_resep_created_at',
		'm_std_bb_resep_updated_at',
		'm_std_bb_resep_deleted_at'
	];
}
