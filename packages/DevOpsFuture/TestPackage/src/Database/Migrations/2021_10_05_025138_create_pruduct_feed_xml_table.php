<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePruductFeedXmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pruduct_feed_xml', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_type');
            $table->mediumText('field_list');
            $table->text('template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pruduct_feed_xml');
    }
}
