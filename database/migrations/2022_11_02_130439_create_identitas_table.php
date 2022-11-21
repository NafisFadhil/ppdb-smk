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
            $table->string('jalur_pendaftaran');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('alamat_desa')->nullable();
            $table->string('alamat_kec')->nullable();
            $table->string('alamat_kota_kab')->nullable();
            $table->char('alamat_rt', 3)->nullable();
            $table->char('alamat_rw', 3)->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->char('jumlah_saudara_kandung', 3)->nullable();
            $table->char('nik', 16)->nullable();
            $table->string('asal_sekolah');
            $table->char('nisn', 10)->nullable();
            $table->char('no_ujian_nasional', 20)->nullable();
            $table->char('no_ijazah', 20)->nullable();
            $table->char('no_wa_ortu', 15);
            $table->char('no_wa_siswa', 15);
            $table->string('nama_jurusan');
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
