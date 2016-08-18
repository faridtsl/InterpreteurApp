<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traces', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('operation');
            $table->integer('user_id')->unsigned();
            $table->integer('concerned_id')->unsigned();
            $table->string('concerned_type');
            $table->string('type');
            $table->boolean('resultat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('traces');
    }
}
