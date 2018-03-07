<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentOrderStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_order_stock', function (Blueprint $table) {

            $table->string('agent_id',20);
            $table->string('country',45)->nullable(true);
            $table->string('delivery_type',20)->nullable(true);
            $table->string('optional',45)->nullable(true);
            $table->string('poscode',20)->nullable(true);
            $table->string('city',45)->nullable(true);
            $table->string('state',45)->nullable(true);
            $table->string('created_by',45);
            $table->string('updated_by',45);
            $table->timestamps();

            $table->primary(['agent_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_order_stock');
    }
}
