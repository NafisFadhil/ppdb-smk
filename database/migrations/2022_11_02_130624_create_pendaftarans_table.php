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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 5)->unique();
            $table->string('nama_admin_pendaftaran')->nullable();
            $table->string('nama_admin_du')->nullable();
            $table->string('nama_admin_seragam')->nullable();

            $table->foreignId('jurusan_id')->default(0);
            $table->foreignId('pembayaran_id')->default(0);
            $table->foreignId('identitas_id')->default(0);
            $table->foreignId('seragam_id')->default(0);
            $table->foreignId('user_id')->default(0);
            $table->foreignId('level_id')->default(1);
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
        // Schema::dropIfExists('pendaftarans');
    }
};
