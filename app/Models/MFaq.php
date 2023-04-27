<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MFaq
 * 
 * @property int $m_faq_id
 * @property string $m_faq_judul
 * @property string $m_faq_deskripsi
 * @property string|null $m_faq_tag
 * @property int $m_faq_created_by
 * @property int|null $m_faq_updated_by
 * @property int|null $m_faq_deleted_by
 * @property Carbon $m_faq_created_at
 * @property Carbon|null $m_faq_updated_at
 * @property Carbon|null $m_faq_deleted_at
 *
 * @package App\Models
 */
class MFaq extends Model
{
	protected $table = 'm_faq';
	protected $primaryKey = 'm_faq_id';
	public $timestamps = false;

	protected $casts = [
		'm_faq_created_by' => 'int',
		'm_faq_updated_by' => 'int',
		'm_faq_deleted_by' => 'int',
		'm_faq_created_at' => 'datetime',
		'm_faq_updated_at' => 'datetime',
		'm_faq_deleted_at' => 'datetime'
	];

	protected $fillable = [
		'm_faq_judul',
		'm_faq_deskripsi',
		'm_faq_tag',
		'm_faq_created_by',
		'm_faq_updated_by',
		'm_faq_deleted_by',
		'm_faq_created_at',
		'm_faq_updated_at',
		'm_faq_deleted_at'
	];
}
