<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_package', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->integer('package_id')->default('0')->comment('package product id');
			$table->integer('product_id')->default('0')->comment('product id');
            $table->integer('quantity')->default('1')->comment('quantity product');
            $table->string('description')->default('')->comment('');
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
        Schema::dropIfExists('product_package');
    }
}
