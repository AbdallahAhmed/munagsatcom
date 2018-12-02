<?php

use Illuminate\Database\Migrations\Migration;

class CreateChancesOffersFilesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chances_offers_files', function ($table) {
            $table->integer("chance_id")->default(0)->index();
            $table->integer("media_id")->index();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('units');
    }
}
