<?php

use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("activities", function ($table) {

            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->integer('user_id')->default(0)->index();
            $table->integer('status')->default(0)->index();
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
        Schema::drop('tender_orgs');
    }
}