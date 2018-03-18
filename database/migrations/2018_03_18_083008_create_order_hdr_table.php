<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_hdr', function (Blueprint $table) {
            $table->string('order_no', 15);
            $table->integer('agent_id');
            $table->string('invoice_no', 15);
            $table->integer('total_items');
            $table->integer('gst');
            $table->decimal('shipping_fee', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->integer('delivery_type');
            $table->string('purchase_date', 10);
            $table->string('status', 2);
            $table->integer('bill_address');
            $table->integer('ship_address');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->primary('order_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_hdr');
    }
}
