<?php

use Illuminate\Database\Migrations\Migration;

class CreateCompaniesFilesTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_files', function ($table) {
            $table->integer("company_id")->index();
            $table->integer("file_id")->index();
        });

    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies_files');
    }
}
