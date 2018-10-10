<?php

use Illuminate\Database\Migrations\Migration;

class CreateSectorsTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->integer("status")->default(0)->index();
            $table->integer("user_id")->index();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sectors');
    }
}
