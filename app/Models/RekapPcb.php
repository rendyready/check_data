<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapPcb
 * 
 * @property int $id
 * @property string $rekap_pcb_id
 * @property string $rekap_pcb_code
 * @property Carbon $rekap_pcb_tgl
 * @property string $rekap_pcb_gudang_asal_code
 * @property string $rekap_pcb_waroeng
 * @property string $rekap_pcb_aksi
 * @property string $rekap_pcb_brg_asal_code
 * @property string $rekap_pcb_brg_asal_nama
 * @property string $rekap_pcb_brg_asal_satuan
 * @property string $rekap_pcb_brg_asal_qty
 * @property float $rekap_pcb_brg_asal_hppisi
 * @property string $rekap_pcb_brg_hasil_code
 * @property string $rekap_pcb_brg_hasil_nama
 * @property string $rekap_pcb_brg_hasil_satuan
 * @property string $rekap_pcb_brg_hasil_qty
 * @property float $rekap_pcb_brg_hasil_hpp
 * @property int $rekap_pcb_created_by
 * @property string $rekap_pcb_created_by_name
 * @property int|null $rekap_pcb_updated_by
 * @property int|null $rekap_pcb_deleted_by
 * @property Carbon $rekap_pcb_created_at
 * @property Carbon|null $rekap_pcb_updated_at
 * @property Carbon|null $rekap_pcb_deleted_at
 *
 * @package App\Models
 */
class RekapPcb extends Model
{
	protected $table = 'rekap_pcb';
	public $timestamps = false;

	protected $casts = [
		'rekap_pcb_brg_asal_hppisi' => 'float',
		'rekap_pcb_brg_hasil_hpp' => 'float',
		'rekap_pcb_created_by' => 'int',
		'rekap_pcb_updated_by' => 'int',
		'rekap_pcb_deleted_by' => 'int'
	];

	protected $dates = [
		'rekap_pcb_tgl',
		'rekap_pcb_created_at',
		'rekap_pcb_updated_at',
		'rekap_pcb_deleted_at'
	];

	protected $fillable = [
		'rekap_pcb_id',
		'rekap_pcb_code',
		'rekap_pcb_tgl',
		'rekap_pcb_gudang_asal_code',
		'rekap_pcb_waroeng',
		'rekap_pcb_aksi',
		'rekap_pcb_brg_asal_code',
		'rekap_pcb_brg_asal_nama',
		'rekap_pcb_brg_asal_satuan',
		'rekap_pcb_brg_asal_qty',
		'rekap_pcb_brg_asal_hppisi',
		'rekap_pcb_brg_hasil_code',
		'rekap_pcb_brg_hasil_nama',
		'rekap_pcb_brg_hasil_satuan',
		'rekap_pcb_brg_hasil_qty',
		'rekap_pcb_brg_hasil_hpp',
		'rekap_pcb_created_by',
		'rekap_pcb_created_by_name',
		'rekap_pcb_updated_by',
		'rekap_pcb_deleted_by',
		'rekap_pcb_created_at',
		'rekap_pcb_updated_at',
		'rekap_pcb_deleted_at'
	];
}
