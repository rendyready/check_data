<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MGudang
 * 
 * @property int $id
 * @property string $m_gudang_id
 * @property string $m_gudang_code
 * @property string $m_gudang_nama
 * @property int $m_gudang_m_w_id
 * @property string $m_gudang_m_w_nama
 * @property int $m_gudang_created_by
 * @property int|null $m_gudang_updated_by
 * @property int|null $m_gudang_deleted_by
 * @property Carbon $m_gudang_created_at
 * @property Carbon|null $m_gudang_updated_at
 * @property Carbon|null $m_gudang_deleted_at
 *
 * @package App\Models
 */
class MGudang extends Model
{
	protected $table = 'm_gudang';
	public $timestamps = false;

	protected $casts = [
		'm_gudang_m_w_id' => 'int',
		'm_gudang_created_by' => 'int',
		'm_gudang_updated_by' => 'int',
		'm_gudang_deleted_by' => 'int'
	];

	protected $dates = [
		'm_gudang_created_at',
		'm_gudang_updated_at',
		'm_gudang_deleted_at'
	];

	protected $fillable = [
		'm_gudang_id',
		'm_gudang_code',
		'm_gudang_nama',
		'm_gudang_m_w_id',
		'm_gudang_m_w_nama',
		'm_gudang_created_by',
		'm_gudang_updated_by',
		'm_gudang_deleted_by',
		'm_gudang_created_at',
		'm_gudang_updated_at',
		'm_gudang_deleted_at'
	];
}
