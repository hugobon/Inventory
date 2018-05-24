<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigStockadjustmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_stockadjustment', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->string('adjustment')->comment('Stock Adjustment');
			$table->longText('remarks');
			$table->integer('status')->comment('0: inactive, 1: active')->default('1');
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
        Schema::dropIfExists('config_stockadjustment');
    }
}
