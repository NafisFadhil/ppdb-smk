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
            $table->string('jenis_kelamin');
            $table->string('asal_sekolah');
            $table->string('no_wa_siswa', 15);
            $table->string('nama_jurusan');
            $table->string('no_wa_ortu', 15)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('alamat_desa')->nullable();
            $table->string('alamat_kec')->nullable();
            $table->string('alamat_kota_kab')->nullable();
            $table->unsignedTinyInteger('alamat_rt')->nullable();
            $table->unsignedTinyInteger('alamat_rw')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->unsignedTinyInteger('jumlah_saudara_kandung')->nullable();
            $table->char('nik', 16)->nullable();
            $table->char('nisn', 10)->nullable();
            $table->char('no_ujian_nasional', 20)->nullable();
            $table->string('no_ijazah', 30)->nullable();

            $table->boolean('reset')->default(false);
            $table->unsignedTinyInteger('old_status_id')->default(0);

            $table->boolean('verifikasi')->default(false);
            $table->string('admin_verifikasi')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->foreignId('jalur_pendaftaran_id');
            $table->foreignId('status_id')->default(1);
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
