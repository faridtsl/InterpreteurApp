<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeTraduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('demandes_traductions', function (Blueprint $table) {
            $table->integer('demande_id')->unsigned();
            $table->integer('traduction_id')->unsigned();
            $table->softDeletes();

            #Constraints
            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');

            $table->foreign('traduction_id')
                ->references('id')
                ->on('traductions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('demandes_traductions');
    }
}
