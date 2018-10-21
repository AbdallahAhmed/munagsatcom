<?php

use Illuminate\Database\Migrations\Migration;

class CreateTendersFilesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tenders_files", function (\Illuminate\Database\Schema\Blueprint $table) {

            $table->integer('tender_id')->index();
            $table->integer('file_id')->index();
        });

    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenders_files');
    }
}
