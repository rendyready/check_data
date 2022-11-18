<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MKaryawan
 * 
 * @property int $m_karyawan
 * @property string $m_karyawan_nama
 * @property string $m_karyawan_panggilan
 * @property string $m_karyawan_nik
 * @property string|null $m_karyawan_no_kk
 * @property string|null $m_karyawan_kota_lahir
 * @property Carbon|null $m_karyawan_tgl_lahir
 * @property string|null $m_karyawan_jenis_kelamin
 * @property string|null $m_karyawan_agama
 * @property string|null $m_karyawan_status_nikah
 * @property Carbon|null $m_karyawan_tgl_nikah
 * @property string $m_karyawan_kota_asal
 * @property string $m_karyawan_provinsi_asal
 * @property string $m_karyawan_alamat_asal
 * @property string $m_karyawan_kota_tinggal
 * @property string $m_karyawan_provinsi_tinggal
 * @property string $m_karyawan_alamat_tinggal
 * @property string $m_karyawan_handphone
 * @property string $m_karyawan_email
 * @property string $m_karyawan_kontak_keluarga
 * @property string|null $m_karyawan_doc_profil
 * @property string|null $m_karyawan_doc_ktp
 * @property string|null $m_karyawan_doc_kk
 * @property string|null $m_karyawan_doc_bpjs
 * @property string|null $m_karyawan_doc_bpjstk
 * @property string|null $m_karyawan_doc_akta
 * @property string|null $m_karyawan_doc_ijazah
 * @property int|null $m_karyawan_tinggi_badan
 * @property float|null $m_karyawan_berat_badan
 * @property string|null $m_karyawan_golongan_darah
 * @property string|null $m_karyawan_penyakit_bawaan
 * @property string|null $m_karyawan_bpjs
 * @property string|null $m_karyawan_bpjstk
 * @property Carbon|null $m_karyawan_tgl_diterima
 * @property Carbon|null $m_karyawan_tgl_penetapan
 * @property string|null $m_karyawan_npwp
 * @property string|null $m_karyawan_nip
 * @property float|null $m_karyawan_ukuran_sepatu
 * @property string|null $m_karyawan_ukuran_seragam
 * @property string|null $m_karyawan_ukuran_topi
 * @property string|null $m_karyawan_rekening_bank
 * @property string|null $m_karyawan_nama_bank
 * @property string $m_karyawan_wilayah_kerja
 * @property string|null $m_karyawan_status
 * @property int|null $m_karyawan_user
 * @property int $m_karyawan_created_by
 * @property int|null $m_karyawan_updated_by
 * @property Carbon $m_karyawan_created_at
 * @property Carbon|null $m_karyawan_updated_at
 * @property Carbon|null $m_karyawan_deleted_at
 *
 * @package App\Models
 */
class MKaryawan extends Model
{
	protected $table = 'm_karyawan';
	protected $primaryKey = 'm_karyawan';
	public $timestamps = false;

	protected $casts = [
		'm_karyawan_tinggi_badan' => 'int',
		'm_karyawan_berat_badan' => 'float',
		'm_karyawan_ukuran_sepatu' => 'float',
		'm_karyawan_user' => 'int',
		'm_karyawan_created_by' => 'int',
		'm_karyawan_updated_by' => 'int'
	];

	protected $dates = [
		'm_karyawan_tgl_lahir',
		'm_karyawan_tgl_nikah',
		'm_karyawan_tgl_diterima',
		'm_karyawan_tgl_penetapan',
		'm_karyawan_created_at',
		'm_karyawan_updated_at',
		'm_karyawan_deleted_at'
	];

	protected $fillable = [
		'm_karyawan_nama',
		'm_karyawan_panggilan',
		'm_karyawan_nik',
		'm_karyawan_no_kk',
		'm_karyawan_kota_lahir',
		'm_karyawan_tgl_lahir',
		'm_karyawan_jenis_kelamin',
		'm_karyawan_agama',
		'm_karyawan_status_nikah',
		'm_karyawan_tgl_nikah',
		'm_karyawan_kota_asal',
		'm_karyawan_provinsi_asal',
		'm_karyawan_alamat_asal',
		'm_karyawan_kota_tinggal',
		'm_karyawan_provinsi_tinggal',
		'm_karyawan_alamat_tinggal',
		'm_karyawan_handphone',
		'm_karyawan_email',
		'm_karyawan_kontak_keluarga',
		'm_karyawan_doc_profil',
		'm_karyawan_doc_ktp',
		'm_karyawan_doc_kk',
		'm_karyawan_doc_bpjs',
		'm_karyawan_doc_bpjstk',
		'm_karyawan_doc_akta',
		'm_karyawan_doc_ijazah',
		'm_karyawan_tinggi_badan',
		'm_karyawan_berat_badan',
		'm_karyawan_golongan_darah',
		'm_karyawan_penyakit_bawaan',
		'm_karyawan_bpjs',
		'm_karyawan_bpjstk',
		'm_karyawan_tgl_diterima',
		'm_karyawan_tgl_penetapan',
		'm_karyawan_npwp',
		'm_karyawan_nip',
		'm_karyawan_ukuran_sepatu',
		'm_karyawan_ukuran_seragam',
		'm_karyawan_ukuran_topi',
		'm_karyawan_rekening_bank',
		'm_karyawan_nama_bank',
		'm_karyawan_wilayah_kerja',
		'm_karyawan_status',
		'm_karyawan_user',
		'm_karyawan_created_by',
		'm_karyawan_updated_by',
		'm_karyawan_created_at',
		'm_karyawan_updated_at',
		'm_karyawan_deleted_at'
	];
}
