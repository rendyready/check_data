<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MModalTipe
 * 
 * @property int $m_modal_tipe_id
 * @property string $m_modal_tipe_nama
 * @property int|null $m_modal_tipe_parent_id
 * @property float|null $m_modal_tipe_nominal
 * @property float|null $m_modal_tipe_urut
 * @property int $m_modal_tipe_created_by
 * @property Carbon $m_modal_tipe_created_at
 * @property int|null $m_modal_tipe_updated_by
 * @property Carbon|null $m_modal_tipe_updated_at
 * @property Carbon|null $m_modal_tipe_deleted_at
 *
 * @package App\Models
 */
class MModalTipe extends Model
{
	protected $table = 'm_modal_tipe';
	protected $primaryKey = 'm_modal_tipe_id';
	public $timestamps = false;

	protected $casts = [
		'm_modal_tipe_parent_id' => 'int',
		'm_modal_tipe_nominal' => 'float',
		'm_modal_tipe_urut' => 'float',
		'm_modal_tipe_created_by' => 'int',
		'm_modal_tipe_updated_by' => 'int'
	];

	protected $dates = [
		'm_modal_tipe_created_at',
		'm_modal_tipe_updated_at',
		'm_modal_tipe_deleted_at'
	];

	protected $fillable = [
		'm_modal_tipe_nama',
		'm_modal_tipe_parent_id',
		'm_modal_tipe_nominal',
		'm_modal_tipe_urut',
		'm_modal_tipe_created_by',
		'm_modal_tipe_created_at',
		'm_modal_tipe_updated_by',
		'm_modal_tipe_updated_at',
		'm_modal_tipe_deleted_at'
	];
	public function m_modal_tipe()
	{
		return $this->belongsTo(MModalTipe::class, 'm_modal_tipe_parent_id');
	}
}
