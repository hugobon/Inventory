<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockadjustmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockadjustment', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->integer('product_id')->comment('product');
			$table->string('product_name')->comment('name at that time')->default('-');
			$table->integer('adjustment_id')->comment('config_stockadjustment');
			$table->integer('quantity')->comment('quantity stock');
			$table->longText('remarks');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->datetime('created_at');
			$table->integer('updated_by')->comment('User ID')->nullable();
			$table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockadjustment');
    }
}
