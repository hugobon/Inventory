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
    	Schema::dropIfExists('supdetail');
        Schema::dropIfExists('supplier');
        Schema::create('supplier', function (Blueprint $table) {
			$table->increments('id');
			$table->string('supplier_code',10)->unique();
			$table->string('company_name', 150);
			$table->string('street1', 255);
			$table->string('street2', 255)->nullable();
			$table->integer('poscode');
			$table->string('city', 100);
			$table->string('state', 100);
			$table->string('country', 100);
			$table->string('tel', 16);
			$table->string('fax', 16)->nullable();
			$table->string('email', 150);
			$table->string('attn_no', 16)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
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
        Schema::table('supdetail', function (Blueprint $table) {
            //
        });
    }
}
