<?php

use Illuminate\Database\Migrations\Migration;

class CreateChancesUnitsTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chances_units', function ($table) {

            $table->integer('chance_id');
            $table->integer('unit_id');
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chances_units');
    }
}
