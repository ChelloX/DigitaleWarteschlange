<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueueUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('queue_users', function (Blueprint $table) {
            $table->id();
            $table->string("uuid"); //Cookie-Ref
            $table->integer("wartenummer");
            $table->string("info")->nullable();

        $table->unsignedBigInteger("queue_id");
        $table->foreign('queue_id')->references('id')->on('queues');


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
        Schema::dropIfExists('queue_users');
    }
}
