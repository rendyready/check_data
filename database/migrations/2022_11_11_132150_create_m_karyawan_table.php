<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_karyawan', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_karyawan_id')->unique();
            // Data Pribadi
            $table->string('m_karyawan_nama');
            $table->string('m_karyawan_panggilan');
            $table->string('m_karyawan_nik')->comment('Nomor Induk Kependudukan'); // No KTP
            $table->string('m_karyawan_no_kk')->nullable()->default(NULL);
            $table->string('m_karyawan_kota_lahir')->nullable();
            $table->date('m_karyawan_tgl_lahir')->nullable();
            $table->string('m_karyawan_jenis_kelamin', 10)->nullable();
            $table->string('m_karyawan_agama', 20)->nullable();
            $table->string('m_karyawan_status_nikah', 20)->nullable();
            $table->date('m_karyawan_tgl_nikah')->nullable();

            // Data Alamat dan Kontak
            $table->string('m_karyawan_kota_asal')->nullable();
            $table->string('m_karyawan_provinsi_asal')->nullable();
            $table->text('m_karyawan_alamat_asal')->nullable();
            $table->string('m_karyawan_kota_tinggal')->nullable();
            $table->string('m_karyawan_provinsi_tinggal')->nullable();
            $table->text('m_karyawan_alamat_tinggal')->nullable();
            $table->string('m_karyawan_handphone');
            $table->text('m_karyawan_email')->nullable();
            $table->string('m_karyawan_kontak_keluarga')->nullable();

            // Dokumen Karyawan
            $table->longText('m_karyawan_doc_profil')->nullable();
            $table->longText('m_karyawan_doc_ktp')->nullable();
            $table->longText('m_karyawan_doc_kk')->nullable();
            $table->longText('m_karyawan_doc_bpjs')->nullable();
            $table->longText('m_karyawan_doc_bpjstk')->nullable();
            $table->longText('m_karyawan_doc_akta')->nullable();
            $table->longText('m_karyawan_doc_ijazah')->nullable();

            // Data Kesehatan
            $table->integer('m_karyawan_tinggi_badan')->nullable();
            $table->decimal('m_karyawan_berat_badan',8,2)->nullable();
            $table->string('m_karyawan_golongan_darah', 3)->nullable();
            $table->string('m_karyawan_penyakit_bawaan')->nullable();
            $table->string('m_karyawan_bpjs')->nullable();
            $table->string('m_karyawan_bpjstk')->nullable();
            $table->string('m_karyawan_indek_kebugaran')->nullable();
            
            
            // Data Kepegawaian
            $table->date('m_karyawan_tgl_diterima')->nullable()->default(NULL);
            $table->date('m_karyawan_tgl_penetapan')->nullable()->default(NULL);
            $table->string('m_karyawan_npwp')->nullable();
            $table->string('m_karyawan_nip')->nullable()->comment('Nomor Induk Pegawai'); //No Induk Pegawai
            $table->decimal('m_karyawan_ukuran_sepatu',8,2)->nullable();
            $table->string('m_karyawan_ukuran_seragam', 10)->nullable();
            $table->string('m_karyawan_ukuran_topi', 10)->nullable();
            $table->string('m_karyawan_rekening_bank')->nullable();
            $table->string('m_karyawan_nama_bank')->nullable();
            $table->string('m_karyawan_wilayah_kerja'); //Value 'Manajemen Pusat', 'Manajemen Area', 'Waroeng'
            $table->string('m_karyawan_status')->nullable()->default('aktif');


            $table->bigInteger('m_karyawan_user')->nullable()->default(NULL);
            $table->string('m_karyawan_status_sync', 20)->default('send');

            $table->bigInteger('m_karyawan_created_by');
            $table->bigInteger('m_karyawan_updated_by')->nullable();
            $table->bigInteger('m_karyawan_deleted_by')->nullable();
            $table->timestampTz('m_karyawan_created_at')->useCurrent();
            $table->timestampTz('m_karyawan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_karyawan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_karyawan');
    }
};
