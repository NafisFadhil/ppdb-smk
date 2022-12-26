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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();

            $table->string('biaya_pendaftaran')->nullable();
            $table->string('tagihan_pendaftaran')->nullable();
            $table->bigInteger('admin_pendaftaran_id')->unsigned()->nullable();
            $table->boolean('lunas_pendaftaran')->default(false);
            $table->timestamp('tanggal_lunas_pendaftaran')->nullable();
            
            $table->string('biaya_daftar_ulang')->nullable();
            $table->string('tagihan_daftar_ulang')->nullable();
            $table->bigInteger('admin_daftar_ulang_id')->unsigned()->nullable();
            $table->boolean('lunas_daftar_ulang')->default(false);
            $table->timestamp('tanggal_lunas_daftar_ulang')->nullable();

            $table->string('biaya_seragam')->nullable();
            $table->string('tagihan_seragam')->nullable();
            $table->bigInteger('admin_seragam_id')->unsigned()->nullable();
            $table->boolean('lunas_seragam')->default(false);
            $table->timestamp('tanggal_lunas_seragam')->nullable();

            $table->foreignId('identitas_id');
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
        Schema::dropIfExists('tagihans');
    }
};
