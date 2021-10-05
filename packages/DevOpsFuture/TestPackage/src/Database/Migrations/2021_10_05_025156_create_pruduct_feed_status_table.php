<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePruductFeedStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pruduct_feed_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_type');
            $table->string('product_identifier');
            $table->string('external_indicator');
            $table->string('external_product_identifier');
            $table->string('feed_type');    // update
            $table->string('feed_status');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pruduct_feed_status');
    }
}
