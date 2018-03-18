<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #product
        Schema::table('product', function (Blueprint $table) {
			$table->string('name')->default('')->after('code');
			$table->longText('description')->default('')->change();
			$table->string('remarks')->default('')->comment('Remarks back end')->after('quantity');
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
