<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string("uuid");
            $table->integer("expected_time")->nullable();
            $table->dateTime("close_time")->nullable();
            $table->string("info")->nullable();
            $table->string("name");
            $table->string("status");

            $table->unsignedBigInteger("poi_id");
            $table->foreign('poi_id')->references('id')->on('pois');

            $table->integer("current_user");


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
        Schema::dropIfExists('queues');
    }
}
