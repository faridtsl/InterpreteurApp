<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('factures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('devi_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            #Constraints
            $table->foreign('devi_id')
                ->references('id')
                ->on('devis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('factures');
    }
}
