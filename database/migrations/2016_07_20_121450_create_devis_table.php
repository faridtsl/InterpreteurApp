<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->increments('id');
            $table->float('total');
            $table->integer('user_id')->unsigned();
            $table->integer('etat_id')->unsigned();
            $table->integer('demande_id')->unsigned();
            $table->integer('interpreteur_id')->unsigned();
            $table->timestamps();
            $table->timestamp('date_envoi_mail');
            $table->softDeletes();

            #Constraints
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('devis');
    }
}