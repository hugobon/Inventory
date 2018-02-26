<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_image', function (Blueprint $table) {
			$table->increments('id')->unique();
			$table->integer('product_id')->default('0')->comment('product id');
            $table->string('type')->comment('type');
            $table->string('description')->default('')->comment('');
			$table->string('file_name')->default('')->comment('image name');
			$table->string('path')->default('')->comment('url image');
			$table->integer('status')->default('0')->comment('1: profile, 0: none');
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
        Schema::dropIfExists('product_image');
    }
}
