<?php

use Illuminate\Database\Migrations\Migration;

class CreateChancesSectorsTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chances_sectors', function ($table) {

            $table->integer('chance_id');
            $table->integer('sector_id');
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chances_sectors');
    }
}
