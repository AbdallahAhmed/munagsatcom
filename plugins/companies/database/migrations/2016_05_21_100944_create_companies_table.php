<?php

use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function ($table) {
            $table->increments('id');
            $table->string("name")->index();
            $table->string("first_name")->index();
            $table->string("last_name")->index();
            $table->string("image_id")->nullable()->index();
            $table->integer("user_id")->default(0)->index();
            $table->string("blocked")->default(0)->index();
            $table->string("block_reason")->default(0)->index();
            $table->string("status")->default(0)->index();
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
        Schema::drop('companies');
    }
}
