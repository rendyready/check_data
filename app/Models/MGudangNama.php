<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MGudangNama
 * 
 * @property int $m_gudang_nama_id
 * @property string $m_gudang_nama
 * @property int $m_gudang_nama_created_by
 * @property int|null $m_gudang_nama_updated_by
 * @property int|null $m_gudang_nama_deleted_by
 * @property Carbon $m_gudang_nama_created_at
 * @property Carbon|null $m_gudang_nama_updated_at
 * @property Carbon|null $m_gudang_nama_deleted_at
 *
 * @package App\Models
 */
class MGudangNama extends Model
{
	protected $table = 'm_gudang_nama';
	protected $primaryKey = 'm_gudang_nama_id';
	public $timestamps = false;

	protected $casts = [
		'm_gudang_nama_created_by' => 'int',
		'm_gudang_nama_updated_by' => 'int',
		'm_gudang_nama_deleted_by' => 'int',
		'm_gudang_nama_created_at' => 'datetime',
		'm_gudang_nama_updated_at' => 'datetime',
		'm_gudang_nama_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_gudang_nama',
		'm_gudang_nama_created_by',
		'm_gudang_nama_updated_by',
		'm_gudang_nama_deleted_by',
		'm_gudang_nama_created_at',
		'm_gudang_nama_updated_at',
		'm_gudang_nama_deleted_at'
	];
}
