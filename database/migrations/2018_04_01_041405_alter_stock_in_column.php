<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStockInColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_in', function (Blueprint $table) {
            //
            $table->renameColumn('stock_supplier', 'supplier_id');
            $table->dropColumn('stock_product');
            $table->dropColumn('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_in', function (Blueprint $table) {
            //
        });
    }
}
