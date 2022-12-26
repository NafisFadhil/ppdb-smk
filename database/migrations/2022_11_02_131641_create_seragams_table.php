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
        Schema::create('seragams', function (Blueprint $table) {
            $table->id();
            
            $table->string('ukuran_wearpack', 10)->nullable();
            $table->string('ukuran_olahraga', 10)->nullable();
            $table->string('ukuran_almamater', 10)->nullable();
            $table->string('keterangan')->nullable();
            
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
        Schema::dropIfExists('seragams');
    }
};
