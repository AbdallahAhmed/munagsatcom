<?php

use Illuminate\Database\Migrations\Migration;

class CreateCentersServicesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers_services', function ($table) {
            $table->integer("center_id")->index();
            $table->integer('service_id')->index();

        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centers_services');
    }
}
