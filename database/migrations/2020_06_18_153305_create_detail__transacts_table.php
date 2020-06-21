<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__transacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transact_id')->unsigned()->index();
            $table->integer('treatment_price_id')->unsigned()->index();
            $table->integer('treatment_type_id')->unsigned()->index();
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('transact_id')->references('id')->on('transacts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('treatment_price_id')->references('id')->on('treatment__prices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('treatment_type_id')->references('id')->on('treatment_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail__transacts');
    }
}
