<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInProductFeedStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_feed_statuses', function (Blueprint $table) {
            $table->mediumText('result_document_id')->after('id')->nullable();
            $table->mediumText('document_id')->after('id')->nullable();
            $table->mediumText('feed_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_feed_statuses', function (Blueprint $table) {
            $table->dropColumn('result_document_id');
            $table->dropColumn('document_id');
            $table->dropColumn('feed_id');
        });
    }
}
