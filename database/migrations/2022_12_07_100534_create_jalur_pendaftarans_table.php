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
        Schema::create('jalur_pendaftarans', function (Blueprint $table) {
            $table->id();

            $table->string('jalur');
            $table->string('subjalur1')->nullable();
            $table->string('subjalur2')->nullable();
            $table->string('subjalur3')->nullable();

            $table->unsignedMediumInteger('biaya_pendaftaran')->default(0);
            $table->unsignedMediumInteger('biaya_daftar_ulang')->default(0);
            $table->unsignedMediumInteger('biaya_seragam')->default(0);
            $table->unsignedMediumInteger('biaya_bonus')->default(0);

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
        Schema::dropIfExists('jalur_pendaftarans');
    }
};
