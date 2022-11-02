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

            // Data Pribadi
            $table->string('nisn');
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->text('alamat_rumah');
            $table->string('tempat_tanggal_lahir');

            // Data SMP
            $table->string('asal_smp');
            $table->text('alamat_smp');

            // Relation
            // $table->foreignId('pendaftaran_id');
            // $table->foreignId('daftar_ulang_id');
            // $table->timestamps();
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
