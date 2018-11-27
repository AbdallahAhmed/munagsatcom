<?php

use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function ($table) {
            $table->increments('id');
            $table->string('path');
            $table->string('name');
            $table->string('type');
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
        Schema::drop('files');
    }
}
