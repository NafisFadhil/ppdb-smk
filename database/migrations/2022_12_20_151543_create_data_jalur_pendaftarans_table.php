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
        Schema::create('data_jalur_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('jalur');
            $table->string('subjalur')->nullable();

            $table->unsignedMediumInteger('biaya_pendaftaran')->default(0);
            $table->unsignedMediumInteger('biaya_daftar_ulang')->default(0);
            $table->unsignedMediumInteger('biaya_seragam')->default(0);
            $table->unsignedMediumInteger('biaya_bonus')->default(0);

            $table->dateTime('periode_awal')->default(now()->setDay(3)->setMonth(1)->setYear(2023)->setTime(0,0,0,0));
            $table->dateTime('periode_akhir')->default(now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jalur_pendaftarans');
    }
};
