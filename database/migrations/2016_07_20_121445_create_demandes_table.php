<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre');
            $table->string('content');
            $table->timestamp('dateEvent');
            $table->timestamp('dateEndEvent');
            $table->integer('user_id')->unsigned();
            $table->integer('etat_id')->unsigned();
            $table->integer('adresse_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('traduction_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            #Constraints
            $table->foreign('adresse_id')
                ->references('id')
                ->on('adresses')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

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
    public function down(){
        Schema::drop('demandes');
    }
}
