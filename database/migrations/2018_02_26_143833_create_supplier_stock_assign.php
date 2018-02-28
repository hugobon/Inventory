<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierStockAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_stock_assign', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_supplier');            
            $table->integer('stock_product');
            $table->integer('barcode');
            $table->date('in_stock_date');
            $table->string('stock_received_number',10);
            $table->text('description');
            $table->integer('created_by')->comment('User ID')->nullable();
            $table->integer('updated_by')->comment('User ID')->nullable();
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
        Schema::dropIfExists('supplier_stock_assign');
    }
}
