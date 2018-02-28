<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeToAblenotnullAgentOrderStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_order_stock', function (Blueprint $table) {
            
            $table->string('created_by',45)->nullable(true)->change();
            $table->string('updated_by',45)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_order_stock', function (Blueprint $table) {
            //
        });
    }
}
