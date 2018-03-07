<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSupdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supdetail', function (Blueprint $table) {
            $table->renameColumn('region','state');
			$table->dropPrimary('supdetail_comp_code_primary');
			$table->renameColumn('comp_code','sup_code');
			$table->unique('sup_code');
			$table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supdetail', function (Blueprint $table) {
            //
        });
    }
}
