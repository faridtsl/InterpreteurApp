<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraductionsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('traductions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source')->unsigned();
            $table->integer('cible')->unsigned();
            $table->timestamps();

            #Constraints
            $table->foreign('source')
                ->references('id')
                ->on('langues')
                ->onDelete('cascade');

            $table->foreign('cible')
                ->references('id')
                ->on('langues')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('traductions');
    }
}
