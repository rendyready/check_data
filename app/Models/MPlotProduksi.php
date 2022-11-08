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
 * @property string $m_plot_produksi_nama
 * @property int $m_plot_produksi_created_by
 * @property Carbon $m_plot_produksi_created_at
 * @property int|null $m_plot_produksi_updated_by
 * @property Carbon|null $m_plot_produksi_updated_at
 * @property Carbon|null $m_plot_produksi_deleted_at
 *
 * @package App\Models
 */
class MPlotProduksi extends Model
{
	protected $table = 'm_plot_produksi';
	public $timestamps = false;

	protected $casts = [
		'm_plot_produksi_created_by' => 'int',
		'm_plot_produksi_updated_by' => 'int'
	];

	protected $dates = [
		'm_plot_produksi_created_at',
		'm_plot_produksi_updated_at',
		'm_plot_produksi_deleted_at'
	];

	protected $fillable = [
		'm_plot_produksi_nama',
		'm_plot_produksi_created_by',
		'm_plot_produksi_created_at',
		'm_plot_produksi_updated_by',
		'm_plot_produksi_updated_at',
		'm_plot_produksi_deleted_at'
	];
}
