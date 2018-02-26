<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('type')->comment('1: by item, 2: package 3: monthly promotion');
            $table->string('code')->unique();
            $table->string('description');
			$table->double('price_wm', 12, 2)->default('0');
			$table->double('price_em', 12, 2)->default('0');
			$table->double('price_staff', 12, 2)->default('0');
			$table->double('last_purchase', 12, 2)->comment('last purchase price')->default('0');
			$table->date('start_promotion')->nullable();
			$table->date('end_promotion')->nullable();
			$table->string('promotion_status')->comment('promotion')->default('0');
			$table->string('picture_name')->default('');
			$table->string('picture_path')->default('');
			$table->integer('status')->comment('0: inactive, 1: active')->default('1');
			$table->integer('quantity_min')->comment('minimum stock (reminder)')->default('0');
			$table->integer('quantity')->comment('curent stock')->default('0');
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
        Schema::dropIfExists('product');
    }
}
