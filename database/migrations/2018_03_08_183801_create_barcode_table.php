<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode_value',100);            
            $table->integer('supplier_stock_assign');
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
        Schema::dropIfExists('barcode');
    }
}
