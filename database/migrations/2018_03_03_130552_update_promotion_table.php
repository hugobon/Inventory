<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		# this migration add/remove column in Inventory Product 04-03-2018
		
		#product promotion
        Schema::table('product_promotion', function (Blueprint $table) {
			$table->dateTime('start')->change();
			$table->dateTime('end')->change();
			$table->string('description')->default('')->change();
        });
		
		#product promotion gift
        Schema::table('product_promotion_gift', function (Blueprint $table) {
			$table->dropColumn('product_id');
			$table->string('gift')->default('')->after('promotion_id');
        });
		
		#product
        Schema::table('product', function (Blueprint $table) {
			$table->double('weight', 8, 2)->default('0')->after('last_purchase');
			$table->integer('point')->default('0')->after('last_purchase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
