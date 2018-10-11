<?php

use Illuminate\Database\Migrations\Migration;

class CreateChancesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chances', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("number")->index();
            $table->timestamp("closing_date")->index();
            $table->string("file_name")->index();
            $table->string("file_description")->index();
            $table->integer("media_id")->index();
            $table->string("status")->default(0)->index();
            $table->string("approved")->default(0)->index();
            $table->string("reason")->default("")->index();
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
        Schema::drop('chances');
    }
}
