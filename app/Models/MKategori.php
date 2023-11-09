<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MKategori
 * 
 * @property int $id
 * @property string $m_kategori_nama
 * @property int $m_kategori_m_menu_jenis_id
 * @property int $m_kategori_created_by
 * @property Carbon $m_kategori_created_at
 * @property int|null $m_kategori_updated_by
 * @property Carbon|null $m_kategori_updated_at
 * @property Carbon|null $m_kategori_deleted_at
 *
 * @package App\Models
 */
class MKategori extends Model
{
	protected $table = 'm_kategori';
	public $timestamps = false;

	protected $casts = [
		'm_kategori_m_menu_jenis_id' => 'int',
		'm_kategori_created_by' => 'int',
		'm_kategori_updated_by' => 'int'
	];

	protected $dates = [
		'm_kategori_created_at',
		'm_kategori_updated_at',
		'm_kategori_deleted_at'
	];

	protected $fillable = [
		'm_kategori_nama',
		'm_kategori_m_menu_jenis_id',
		'm_kategori_created_by',
		'm_kategori_created_at',
		'm_kategori_updated_by',
		'm_kategori_updated_at',
		'm_kategori_deleted_at'
	];
}
