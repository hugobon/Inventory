<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_promotion', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->integer('product_id')->default('0')->comment('product id');
            $table->string('description')->default('')->comment('remarks');
			$table->integer('price_checked')->default('0')->comment('promotion price');
			$table->integer('gift_checked')->default('0')->comment('promotion gift');
			$table->dateTime('start')->nullable();
			$table->dateTime('end')->nullable();
			$table->double('price_wm', 12, 2)->default('0')->comment('promotion bfr gst');
			$table->double('price_em', 12, 2)->default('0')->comment('promotion bfr gst');
			$table->double('price_staff', 12, 2)->default('0')->comment('promotion bfr gst');
			$table->integer('status')->comment('1: On, 0: Off')->default('1');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->datetime('created_at');
			$table->integer('updated_by')->comment('User ID')->nullable();
			$table->datetime('updated_at');
        });
		
		#if gift_checked
		Schema::create('product_promotion_gift', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->integer('promotion_id')->default('0')->comment('promotion id');
            $table->string('product_id')->default('')->comment('select product');
			$table->integer('quantity')->default('0')->comment('quantity');
			$table->string('description')->default('')->comment('remarks');
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
        Schema::dropIfExists('product_promotion');
    }
}
