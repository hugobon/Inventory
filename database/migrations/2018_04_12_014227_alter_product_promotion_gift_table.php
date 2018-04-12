<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductPromotionGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		# Empty/ Reset Table Gift sbb Gift string change to product id integer
		DB::table('product_promotion_gift')->truncate();
		
		Schema::table('product_promotion_gift', function (Blueprint $table) {
			$table->integer('product_id')->comment('product id')->default('0')->after('promotion_id');
			$table->dropColumn('gift');
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
