<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TmpTransaction
 * 
 * @property uuid $tmp_transaction_id
 * @property int $tmp_transaction_split_number
 * @property int|null $tmp_transaction_m_t_t_id
 * @property int|null $tmp_transaction_m_w_id
 * @property string|null $tmp_transaction_note_number
 * @property string|null $tmp_transaction_customer_name
 * @property time without time zone|null $tmp_transaction_order_time
 * @property string|null $tmp_transaction_table_list
 * @property int $tmp_transaction_status
 * @property string|null $tmp_transaction_reason_status
 * @property int|null $tmp_transaction_created_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TmpTransaction extends Model
{
	use SoftDeletes;
	protected $table = 'tmp_transaction';
	protected $primaryKey = 'tmp_transaction_id';
	public $incrementing = false;

	protected $casts = [
		'tmp_transaction_id' => 'uuid',
		'tmp_transaction_split_number' => 'int',
		'tmp_transaction_m_t_t_id' => 'int',
		'tmp_transaction_m_w_id' => 'int',
		'tmp_transaction_order_time' => 'time without time zone',
		'tmp_transaction_table_list' => 'binary',
		'tmp_transaction_status' => 'int',
		'tmp_transaction_created_by' => 'int'
	];

	protected $fillable = [
		'tmp_transaction_split_number',
		'tmp_transaction_m_t_t_id',
		'tmp_transaction_m_w_id',
		'tmp_transaction_note_number',
		'tmp_transaction_customer_name',
		'tmp_transaction_order_time',
		'tmp_transaction_table_list',
		'tmp_transaction_status',
		'tmp_transaction_reason_status',
		'tmp_transaction_created_by'
	];
}
