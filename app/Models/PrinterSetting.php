<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PrinterSetting
 * 
 * @property int $printer_setting_id
 * @property string $printer_setting_type
 * @property string|null $printer_setting_address
 * @property string $printer_setting_location
 * @property string $printer_setting_status
 * @property int $printer_setting_created_by
 * @property int|null $printer_setting_deleted_by
 * @property int|null $printer_setting_updated_by
 * @property Carbon $printer_setting_created_at
 * @property Carbon|null $printer_setting_updated_at
 * @property Carbon|null $printer_setting_deleted_at
 *
 * @package App\Models
 */
class PrinterSetting extends Model
{
	protected $table = 'printer_setting';
	protected $primaryKey = 'printer_setting_id';
	public $timestamps = false;

	protected $casts = [
		'printer_setting_created_by' => 'int',
		'printer_setting_deleted_by' => 'int',
		'printer_setting_updated_by' => 'int'
	];

	protected $dates = [
		'printer_setting_created_at',
		'printer_setting_updated_at',
		'printer_setting_deleted_at'
	];

	protected $fillable = [
		'printer_setting_m_w_id',
		'printer_setting_type',
		'printer_setting_address',
		'printer_setting_location',
		'printer_setting_status',
		'printer_setting_created_by',
		'printer_setting_deleted_by',
		'printer_setting_updated_by',
		'printer_setting_created_at',
		'printer_setting_updated_at',
		'printer_setting_deleted_at'
	];
}
