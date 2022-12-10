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

            $table->unsignedMediumInteger('biaya_pendaftaran')->nullable();
            $table->unsignedMediumInteger('tagihan_pendaftaran')->nullable();
            $table->string('admin_pendaftaran')->nullable();
            $table->boolean('lunas_pendaftaran')->default(false);
            
            $table->unsignedMediumInteger('biaya_daftar_ulang')->nullable();
            $table->unsignedMediumInteger('tagihan_daftar_ulang')->nullable();
            $table->string('admin_daftar_ulang')->nullable();
            $table->boolean('lunas_daftar_ulang')->default(false);

            $table->unsignedMediumInteger('biaya_seragam')->nullable();
            $table->unsignedMediumInteger('tagihan_seragam')->nullable();
            $table->string('admin_seragam')->nullable();
            $table->boolean('lunas_seragam')->default(false);

            $table->string('keterangan')->default('-');

            $table->foreignId('identitas_id');
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
