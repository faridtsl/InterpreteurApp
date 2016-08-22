<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisInterpreteurs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('devis_interpreteurs', function (Blueprint $table) {
            $table->integer('interpreteur_id')->unsigned();
            $table->integer('devi_id')->unsigned();
            $table->softDeletes();

            #Constraints
            $table->foreign('interpreteur_id')
                ->references('id')
                ->on('interpreteurs')
                ->onDelete('cascade');

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
    public function down()
    {
        //
    }
}
