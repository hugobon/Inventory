<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentSelectProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_select_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id',10)->unique();
            $table->string('quantity',45);
            $table->float('total_price',12,2);
            $table->string('created_by',45)->nullable();
            $table->string('updated_by',45)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_select_product');
    }
}
