<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MPaymentMethod
 * 
 * @property int $m_payment_method_id
 * @property string $m_payment_method_type
 * @property string $m_payment_method_name
 * @property string|null $m_payment_method_color
 * @property int $m_payment_method_created_by
 * @property int|null $m_payment_method_updated_by
 * @property Carbon|null $m_payment_method_deleted_by
 * @property Carbon|null $m_payment_method_created_at
 * @property Carbon|null $m_payment_method_updated_at
 * @property Carbon|null $m_payment_method_deleted_at
 *
 * @package App\Models
 */
class MPaymentMethod extends Model
{
	protected $table = 'm_payment_method';
	protected $primaryKey = 'm_payment_method_id';
	public $timestamps = false;

	protected $casts = [
		'm_payment_method_created_by' => 'int',
		'm_payment_method_updated_by' => 'int'
	];

	protected $dates = [
		'm_payment_method_deleted_by',
		'm_payment_method_created_at',
		'm_payment_method_updated_at',
		'm_payment_method_deleted_at'
	];

	protected $fillable = [
		'm_payment_method_type',
		'm_payment_method_name',
		'm_payment_method_color',
		'm_payment_method_created_by',
		'm_payment_method_updated_by',
		'm_payment_method_deleted_by',
		'm_payment_method_created_at',
		'm_payment_method_updated_at',
		'm_payment_method_deleted_at'
	];
}
