<?php

use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("details")->nullable()->index();
            $table->integer("price_from")->index();
            $table->string("price_to")->index();
            $table->string('status')->default(0)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();

        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }
}
