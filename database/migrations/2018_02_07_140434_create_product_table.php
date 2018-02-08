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
            $table->increments('id');
            $table->integer('type')->comment('1: by item, 2: package 3: monthly promotion');
            $table->string('code')->unique();
            $table->string('description');
			$table->string('path');
			$table->double('price_wm', 12, 2);
			$table->double('price_em', 12, 2);
			$table->double('price_staff', 12, 2);
			$table->date('start_promotion');
			$table->date('end_promotion');
			$table->string('status')->comment('promotion');
			$table->double('tax_gst', 12, 2);
			$table->integer('created_id')->comment('User ID');
			$table->datetime('created_at');
			$table->integer('updated_id')->comment('User ID');
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
