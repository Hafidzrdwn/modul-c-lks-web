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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('idOrder');
            $table->date('orderDate');
            $table->unsignedBigInteger('idCustomer');
            $table->foreign('idCustomer')->references('idCustomer')->on('customers');
            $table->unsignedBigInteger('idKirim');
            $table->foreign('idKirim')->references('idKirim')->on('kirims');
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
        Schema::dropIfExists('orders');
    }
};
