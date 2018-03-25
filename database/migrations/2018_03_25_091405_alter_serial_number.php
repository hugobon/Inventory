<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSerialNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_serial_number', function (Blueprint $table) {
            //
            $table->renameColumn('supplier_stock_assign', 'stock_in_id');
            $table->renameColumn('barcode_value', 'serial_number')->unique();
            $table->renameColumn('STATUS', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_serial_number', function (Blueprint $table) {
            //
        });
    }
}
