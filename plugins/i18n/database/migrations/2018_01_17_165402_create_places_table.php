<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('parent')->nullable();
            $table->string('code', 10)->nullable();
            $table->json('name')->nullable();
            $table->string('lat', 200)->nullable();
            $table->string('lng', 200)->nullable();
            $table->json('currency')->nullable();
            $table->integer('image_id')->nullable();
            $table->tinyInteger('status')->nullable();

            $table->index('parent', 'parent');
            $table->index('code', 'code');
            $table->index('status', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
