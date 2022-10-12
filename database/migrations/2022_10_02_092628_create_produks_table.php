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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('idProduk');
            $table->string('namaProduk', 20);
            $table->integer('beratProduk');
            $table->string('warnaProduk', 20);
            $table->date('tanggalProduksi');
            $table->decimal('hargaProduk', 10, 2);
            $table->unsignedBigInteger('idKategori');
            $table->foreign('idKategori')->references('idKategori')->on('kategoris');
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
        Schema::dropIfExists('produks');
    }
};
