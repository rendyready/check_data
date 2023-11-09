<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MPlotProduksi
 * 
 * @property int $id
 * @property int $m_plot_produksi_id
 * @property string $m_plot_produksi_nama
 * @property int $m_plot_produksi_created_by
 * @property int|null $m_plot_produksi_updated_by
 * @property int|null $m_plot_produksi_deleted_by
 * @property Carbon $m_plot_produksi_created_at
 * @property Carbon|null $m_plot_produksi_updated_at
 * @property Carbon|null $m_plot_produksi_deleted_at
 * @property string $m_plot_produksi_status_sync
 *
 * @package App\Models
 */
class MPlotProduksi extends Model
{
	protected $table = 'm_plot_produksi';
	public $timestamps = false;

	protected $casts = [
		'm_plot_produksi_id' => 'int',
		'm_plot_produksi_created_by' => 'int',
		'm_plot_produksi_updated_by' => 'int',
		'm_plot_produksi_deleted_by' => 'int',
		'm_plot_produksi_created_at' => 'datetime',
		'm_plot_produksi_updated_at' => 'datetime',
		'm_plot_produksi_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_plot_produksi_id',
		'm_plot_produksi_nama',
		'm_plot_produksi_created_by',
		'm_plot_produksi_updated_by',
		'm_plot_produksi_deleted_by',
		'm_plot_produksi_created_at',
		'm_plot_produksi_updated_at',
		'm_plot_produksi_deleted_at',
		'm_plot_produksi_status_sync'
	];
}
