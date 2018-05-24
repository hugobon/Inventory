<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductWoserialnumAddcolum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_woserialnum', function (Blueprint $table) {
            //
            $table->integer('stock_in_id')->nullable()->after('quantity_reduced');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_woserialnum', function (Blueprint $table) {
            //
        });
    }
}
