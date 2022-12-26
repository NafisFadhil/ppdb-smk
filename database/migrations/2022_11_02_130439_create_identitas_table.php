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
        Schema::create('identitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->string('no_wa_siswa', 15);
            $table->string('no_wa_ortu', 15)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('alamat_desa')->nullable();
            $table->string('alamat_kec')->nullable();
            $table->string('alamat_kota_kab')->nullable();
            $table->tinyInteger('alamat_rt')->unsigned()->nullable();
            $table->tinyInteger('alamat_rw')->unsigned()->nullable();
            $table->tinyInteger('alamat_gg')->unsigned()->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('tahun_lahir_ayah')->nullable();
            $table->string('tahun_lahir_ibu')->nullable();
            $table->tinyInteger('jumlah_saudara_kandung')->unsigned()->nullable();
            $table->char('nik', 16)->nullable();
            $table->char('nisn', 10)->nullable();
            $table->string('no_ujian_nasional', 30)->nullable();
            $table->string('no_ijazah', 30)->nullable();
            $table->boolean('buta_warna')->default(false);
            
            $table->string('session_id')->nullable();
            $table->foreignId('jenis_kelamin_id');
            $table->foreignId('jalur_pendaftaran_id');
            $table->foreignId('status_id')->default(1);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identitas');
    }
};
