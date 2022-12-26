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
        Schema::create('verifikasis', function (Blueprint $table) {
            $table->id();

            $table->boolean('identitas')->default(false);
            $table->timestamp('tanggal_identitas')->nullable();
            $table->integer('admin_identitas_id')->nullable();
            
            $table->boolean('pendaftaran')->default(false);
            $table->timestamp('tanggal_pendaftaran')->nullable();
            $table->integer('admin_pendaftaran_id')->nullable();

            $table->boolean('daftar_ulang')->default(false);
            $table->timestamp('tanggal_daftar_ulang')->nullable();
            $table->integer('admin_daftar_ulang_id')->nullable();

            $table->boolean('seragam')->default(false);
            $table->timestamp('tanggal_seragam')->nullable();
            $table->integer('admin_seragam_id')->nullable();

            $table->boolean('sponsorship')->default(false);
            $table->timestamp('tanggal_sponsorship')->nullable();
            $table->integer('admin_sponsorship_id')->nullable();

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
        Schema::dropIfExists('verifikasis');
    }
};
