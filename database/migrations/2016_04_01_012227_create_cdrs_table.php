<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cdrs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('Type');
			$table->string('Sender');
			$table->string('Destination');
			$table->dateTime('StartDateTime');
			$table->dateTime('EndDateTime');
			$table->integer('Duration');
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
        Schema::drop('Cdrs');
    }
}
