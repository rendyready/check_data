<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MGroupProduk
 * 
 * @property int $id
 * @property string $m_group_produk_id
 * @property string|null $m_group_produk_parent_id
 * @property string $m_group_produk_name
 * @property string $m_group_produk_m_divisi_id
 * @property string $m_group_produk_m_divisi_name
 * @property string|null $m_group_produk_produk_list
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
class MGroupProduk extends Model
{
	protected $table = 'm_group_produk';
	public $timestamps = false;

	protected $casts = [
		'm_group_produk_produk_list' => 'binary',
		'm_group_produk_created_by' => 'int',
		'm_group_produk_updated_by' => 'int',
		'm_group_produk_deleted_by' => 'int',
		'm_group_produk_created_at' => 'datetime',
		'm_group_produk_updated_at' => 'datetime',
		'm_group_produk_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_group_produk_id',
		'm_group_produk_parent_id',
		'm_group_produk_name',
		'm_group_produk_m_divisi_id',
		'm_group_produk_m_divisi_name',
		'm_group_produk_produk_list',
		'm_group_produk_created_by',
		'm_group_produk_created_by_name',
		'm_group_produk_updated_by',
		'm_group_produk_deleted_by',
		'm_group_produk_created_at',
		'm_group_produk_updated_at',
		'm_group_produk_deleted_at'
	];
}
