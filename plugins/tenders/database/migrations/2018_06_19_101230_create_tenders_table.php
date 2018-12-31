<?php

use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tenders", function (\Illuminate\Database\Schema\Blueprint $table) {

            $table->increments('id');
            $table->string('name')->index();
            $table->text('objective');
            $table->string('slug')->unique();
            $table->text('number')->default(0);

            $table->string('address_get_offer')->nullable();
            $table->string('address_files_open')->nullable();
            $table->string('address_execute')->nullable();


            $table->integer('type_id')->default(0)->index();
            $table->integer('cb_id')->default(0)->index();
            $table->integer('is_cb_ratio_active')->default(0)->index();
            $table->integer('org_id')->default(0)->index();
            $table->integer('activity_id')->default(0)->index();
            $table->integer('user_id')->default(0)->index();
            $table->integer('status')->default(0)->index();


            $table->double('cb_real_price',15,2)->default(0)->index();
            $table->double('price',15,2)->default(0)->index();
            $table->double('cb_downloaded_price',15,2)->default(0)->index();


            $table->integer('views')->default(0)->index();
            $table->integer('downloaded')->default(0)->index();

            $table->timestamp('published_at')->default(Carbon\Carbon::now())->index();
            $table->timestamp('last_queries_at')->default(Carbon\Carbon::now())->index();
            $table->timestamp('last_get_offer_at')->default(Carbon\Carbon::now())->index();
            $table->timestamp('files_opened_at')->default(Carbon\Carbon::now())->index();


            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenders');
    }
}
