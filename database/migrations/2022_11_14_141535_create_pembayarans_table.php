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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('biaya_pendaftaran')->default(0);
            $table->boolean('lunas_pendaftaran')->default(false);
            $table->string('ket_pendaftaran')->nullable();
            $table->string('admin_pendaftaran')->nullable();
            $table->unsignedMediumInteger('biaya_daftar_ulang')->default(0);
            $table->boolean('lunas_daftar_ulang')->default(false);
            $table->string('ket_daftar_ulang')->nullable();
            $table->string('admin_daftar_ulang')->nullable();
            $table->unsignedMediumInteger('biaya_seragam')->default(0);
            $table->boolean('lunas_seragam')->default(false);
            $table->string('ket_seragam')->nullable();
            $table->string('admin_seragam')->nullable();
            $table->boolean('bool');
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
        Schema::dropIfExists('pembayarans');
    }
};
