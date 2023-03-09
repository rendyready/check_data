<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MDivisi
 * 
 * @property int $id
 * @property string $m_divisi_id
 * @property string|null $m_divisi_parent_id
 * @property string $m_divisi_name
 * @property int $m_group_produk_created_by
 * @property string $m_group_produk_created_by_name
 * @property int|null $m_group_produk_updated_by
 * @property int|null $m_group_produk_deleted_by
 * @property Carbon $m_group_produk_created_at
 * @property Carbon|null $m_group_produk_updated_at
 * @property Carbon|null $m_group_produk_deleted_at
 *
 * @package App\Models
 */
class MDivisi extends Model
{
	protected $table = 'm_divisi';
	protected $primaryKey = 'm_divisi_id';
	public $timestamps = false;

	protected $casts = [
		'm_divisi_id' => 'string',
		'm_group_produk_created_by' => 'int',
		'm_group_produk_updated_by' => 'int',
		'm_group_produk_deleted_by' => 'int'
	];

	protected $dates = [
		'm_group_produk_created_at',
		'm_group_produk_updated_at',
		'm_group_produk_deleted_at'
	];

	protected $fillable = [
		'm_divisi_id',
		'm_divisi_parent_id',
		'm_divisi_name',
		'm_group_produk_created_by',
		'm_group_produk_created_by_name',
		'm_group_produk_updated_by',
		'm_group_produk_deleted_by',
		'm_group_produk_created_at',
		'm_group_produk_updated_at',
		'm_group_produk_deleted_at'
	];
}
