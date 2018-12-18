<?php

use Illuminate\Database\Migrations\Migration;

class CreateCentersTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function ($table) {

            $table->increments('id');
            $table->string("name")->index();
            $table->string("slug")->unique();
            $table->string("sector_id")->index();
            $table->string("user_id")->index();
            $table->string("address")->nullable()->index();
            $table->string("mobile_number")->nullable()->index();
            $table->string("phone_number")->nullable()->index();
            $table->string("email_address")->index();
            $table->integer("image_id")->nullable();
            $table->string('status')->default(0)->index();
            $table->string('approved')->default(0)->index();
            $table->string('reason')->nullable()->index();
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
        Schema::drop('centers');
    }
}
