<?php

use Illuminate\Database\Migrations\Migration;

class CreateTendersCategoriesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tenders_categories", function (\Illuminate\Database\Schema\Blueprint $table) {

            $table->integer('tender_id')->index();
            $table->integer('category_id')->index();

        });

    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenders_categories');
    }
}
