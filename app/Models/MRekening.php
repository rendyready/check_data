<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MRekening
 * 
 * @property int $m_rekening_id
 * @property int $m_rekening_m_w_id
 * @property string $m_rekening_kategori
 * @property string $m_rekening_no_akun
 * @property string $m_rekening_nama
 * @property float $m_rekening_saldo
 * @property int $m_jenis_nota_created_by
 * @property Carbon $m_jenis_nota_created_at
 * @property int|null $m_jenis_nota_updated_by
 * @property Carbon|null $m_jenis_nota_updated_at
 * @property Carbon|null $m_jenis_nota_deleted_at
 * @package App\Models
 */
class MRekening extends Model
{
	protected $table = 'm_rekening';
	protected $primaryKey = 'm_rekening_id';
	public $timestamps = false;

        protected $casts = [
            'm_rekening_created_by' => 'int',
            'm_rekening_updated_by' => 'int',
            'm_rekening_deleted_by' => 'int',
        ];
    
        protected $dates = [
            'm_rekening_created_at',
            'm_rekening_updated_at',
            'm_rekening_deleted_at'
        ];
    
        protected $fillable = [
            'm_rekening_m_w_id',
            'm_rekening_kategori',
            'm_rekening_no_akun',
            'm_rekening_nama',
            'm_rekening_saldo',
            'm_rekening_deleted_by',
            'm_rekening_updated_by',
            'm_rekening_created_at',
            'm_rekening_updated_at',
            'm_rekening_deleted_at'
        ];
    }