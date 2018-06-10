<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoHdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('do_hdr', function (Blueprint $table) {
            $table->string('do_no', 15);
            $table->string('order_no', 15);            
            $table->string('tracking_no', 20);
            $table->integer('courier_id');
            $table->string('delivery_status', 2);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->primary('do_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('do_hdr');
    }
}
