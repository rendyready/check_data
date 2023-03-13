<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MFaqKelompok
 * 
 * @property int $m_faq_kelompok_id
 * @property int $m_faq_kelompok_m_faq_id
 * @property int $m_faq_kelompok_m_kelompok_id
 * @property int $m_faq_kelompok_created_by
 * @property int|null $m_faq_kelompok_updated_by
 * @property int|null $m_faq_kelompok_deleted_by
 * @property Carbon $m_faq_kelompok_created_at
 * @property Carbon|null $m_faq_kelompok_updated_at
 * @property Carbon|null $m_faq_kelompok_deleted_at
 *
 * @package App\Models
 */
class MFaqKelompok extends Model
{
	protected $table = 'm_faq_kelompok';
	protected $primaryKey = 'm_faq_kelompok_id';
	public $timestamps = false;

	protected $casts = [
		'm_faq_kelompok_m_faq_id' => 'int',
		'm_faq_kelompok_m_kelompok_id' => 'int',
		'm_faq_kelompok_created_by' => 'int',
		'm_faq_kelompok_updated_by' => 'int',
		'm_faq_kelompok_deleted_by' => 'int'
	];

	protected $dates = [
		'm_faq_kelompok_created_at',
		'm_faq_kelompok_updated_at',
		'm_faq_kelompok_deleted_at'
	];

	protected $fillable = [
		'm_faq_kelompok_m_faq_id',
		'm_faq_kelompok_m_kelompok_id',
		'm_faq_kelompok_created_by',
		'm_faq_kelompok_updated_by',
		'm_faq_kelompok_deleted_by',
		'm_faq_kelompok_created_at',
		'm_faq_kelompok_updated_at',
		'm_faq_kelompok_deleted_at'
	];
}
