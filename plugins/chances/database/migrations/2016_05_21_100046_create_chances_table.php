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
            $table->string("file_name")->nullable()->default("")->index();
            $table->string("file_description")->nullable()->default("")->index();
            $table->string("file_path")->nullable()->default("")->index();
            $table->string("status")->default(3)->index();
            $table->string("approved")->nullable()->default("")->index();
            $table->string("reason")->nullable()->default("")->index();
            $table->string("value")->nullable()->default("")->index();
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
