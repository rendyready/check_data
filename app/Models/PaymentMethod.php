<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property int $payment_method_id
 * @property string $payment_method_type
 * @property string $payment_method_name
 * @property string|null $payment_method_logo
 * @property int $payment_method_created_by
 * @property int|null $payment_method_updated_by
 * @property Carbon|null $payment_method_deleted_by
 * @property Carbon|null $payment_method_created_at
 * @property Carbon|null $payment_method_updated_at
 * @property Carbon|null $payment_method_deleted_at
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_method';
	protected $primaryKey = 'payment_method_id';
	public $timestamps = false;

	protected $casts = [
		'payment_method_created_by' => 'int',
		'payment_method_updated_by' => 'int'
	];

	protected $dates = [
		'payment_method_deleted_by',
		'payment_method_created_at',
		'payment_method_updated_at',
		'payment_method_deleted_at'
	];

	protected $fillable = [
		'payment_method_type',
		'payment_method_name',
		'payment_method_logo',
		'payment_method_created_by',
		'payment_method_updated_by',
		'payment_method_deleted_by',
		'payment_method_created_at',
		'payment_method_updated_at',
		'payment_method_deleted_at'
	];
}
