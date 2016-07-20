<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adresse');
            $table->string('numero');
            $table->string('route');
            $table->string('code_postal');
            $table->string('ville');
            $table->string('pays');
            $table->string('departement');
            $table->string('long');
            $table->string('lat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('adresses');
    }
}
