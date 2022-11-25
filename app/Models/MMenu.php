<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MMenu
 * 
 * @property int $id
 * @property string|null $m_menu_code
 * @property string $m_menu_nama
 * @property string $m_menu_urut
 * @property string|null $m_menu_cr
 * @property string $m_menu_status
 * @property string $m_menu_tax
 * @property string $m_menu_sc
 * @property int $m_menu_m_menu_jenis_id
 * @property int|null $m_menu_m_plot_produksi_id
 * @property int $m_menu_created_by
 * @property Carbon $m_menu_created_at
 * @property int|null $m_menu_updated_by
 * @property Carbon|null $m_menu_updated_at
 * @property Carbon|null $m_menu_deleted_at
 *
 * @package App\Models
 */
class MMenu extends Model
{
	protected $table = 'm_menu';
	public $timestamps = false;

	protected $casts = [
		'm_menu_m_menu_jenis_id' => 'int',
		'm_menu_m_plot_produksi_id' => 'int',
		'm_menu_created_by' => 'int',
		'm_menu_updated_by' => 'int'
	];

	protected $dates = [
		'm_menu_created_at',
		'm_menu_updated_at',
		'm_menu_deleted_at'
	];

	protected $fillable = [
		'm_menu_code',
		'm_menu_nama',
		'm_menu_urut',
		'm_menu_cr',
		'm_menu_status',
		'm_menu_tax',
		'm_menu_sc',
		'm_menu_m_menu_jenis_id',
		'm_menu_m_plot_produksi_id',
		'm_menu_created_by',
		'm_menu_created_at',
		'm_menu_updated_by',
		'm_menu_updated_at',
		'm_menu_deleted_at'
	];
}
