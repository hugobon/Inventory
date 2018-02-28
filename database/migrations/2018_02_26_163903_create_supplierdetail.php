<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supdetail', function (Blueprint $table) {
			$table->string('comp_code', 4);
			$table->string('comp_name', 45);
			$table->string('tel', 50);
			$table->string('fax', 50);
			$table->string('attn_no', 50);
			$table->string('email', 225);
			$table->string('add1', 100);
			$table->string('add2', 100);
			$table->string('postal_code', 6);
			$table->string('city', 50);
			$table->string('region', 50);
			$table->string('country', 50);
			$table->string('created_by', 45)->nullable();
			$table->string('updated_by', 45)->nullable();
            $table->timestamps();
			
			$table->primary('comp_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supdetail');
    }
}
