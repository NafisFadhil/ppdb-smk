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
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->text('alamat_rumah');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->char('jumlah_saudara_kandung',2);
            $table->char('nik', 24);
            $table->string('asal_sekolah');
            $table->char('nisn', 24);
            $table->char('no_ujian_nasional', 20);
            $table->char('no_ijazah', 20);
            $table->char('no_wa', 15);
            $table->string('jurusan');
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
