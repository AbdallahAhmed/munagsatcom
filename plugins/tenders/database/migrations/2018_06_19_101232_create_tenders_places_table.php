<?php

use Illuminate\Database\Migrations\Migration;

class CreateTenderPlacessTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tenders_places", function (\Illuminate\Database\Schema\Blueprint $table) {

            $table->integer('tender_id')->index();
            $table->integer('place_id')->index();
        });

    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenders_places');
    }
}
