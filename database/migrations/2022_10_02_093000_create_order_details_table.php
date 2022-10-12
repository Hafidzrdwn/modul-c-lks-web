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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('idOrderDetail');
            $table->integer('jumlahBarang');
            $table->decimal('totalHarga', 11, 2);
            $table->unsignedBigInteger('idOrder');
            $table->foreign('idOrder')->references('idOrder')->on('orders');
            $table->unsignedBigInteger('idProduk');
            $table->foreign('idProduk')->references('idProduk')->on('produks');
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
        Schema::dropIfExists('order_details');
    }
};
