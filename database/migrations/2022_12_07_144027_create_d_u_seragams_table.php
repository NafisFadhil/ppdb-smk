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
        Schema::create('duseragams', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 7)->unique();

            $table->string('ukuran_seragam', 5)->nullable();
            $table->string('keterangan')->nullable();

            $table->boolean('verifikasi')->default(false);
            $table->string('admin_verifikasi')->nullable();

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
        Schema::dropIfExists('duseragams');
    }
};
