<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterpreteursTraductions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('interpreteurs_traductions', function (Blueprint $table) {
            $table->integer('interpreteur_id')->unsigned();
            $table->integer('traduction_id')->unsigned();

            #Constraints
            $table->foreign('interpreteur_id')
                ->references('id')
                ->on('interpreteurs')
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
        Schema::drop('interpreteurs_traductions');
    }
}
