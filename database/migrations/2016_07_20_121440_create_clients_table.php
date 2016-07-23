<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('tel_portable');
            $table->text('commentaire');
            $table->string('tel_fixe');
            $table->string('image');
            $table->integer('user_id')->unsigned();
            $table->integer('adresse_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            #Constraints
            $table->foreign('adresse_id')
                ->references('id')
                ->on('adresses')
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
        Schema::drop('clients');
    }
}
